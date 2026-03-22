<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Models\Appointment;
use App\Models\DoctorSchedule;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AppointmentController extends Controller
{
    /**
     * Crea una nueva cita médica.
     *
     * Validaciones de negocio:
     *  1. El doctor_id debe pertenecer a un usuario con rol 'medico'.
     *  2. El médico debe tener un bloque de horario que cubra la cita ese día.
     *  3. No puede existir ya una cita para el mismo médico, fecha y hora de inicio (422).
     */
    public function store(StoreAppointmentRequest $request): JsonResponse
    {
        $data = $request->validated();

        // 1. Verificar que el usuario seleccionado es un médico
        $doctor = User::find($data['doctor_id']);

        if (! $doctor || ! $doctor->isMedico()) {
            return response()->json([
                'message' => 'El usuario seleccionado no es un médico.',
                'errors'  => ['doctor_id' => ['El doctor_id no corresponde a un médico activo.']],
            ], 422);
        }

        // 2. Obtener el día de la semana en español (sin tildes, igual que la migración)
        $dayMap = [
            'Monday'    => 'lunes',
            'Tuesday'   => 'martes',
            'Wednesday' => 'miercoles',
            'Thursday'  => 'jueves',
            'Friday'    => 'viernes',
            'Saturday'  => 'sabado',
            'Sunday'    => 'domingo',
        ];

        $englishDay = date('l', strtotime($data['appointment_date']));
        $dayOfWeek  = $dayMap[$englishDay];

        // Comprobar que el médico tiene un bloque de horario que cubra la cita ese día
        $scheduleExists = DoctorSchedule::where('user_id', $data['doctor_id'])
            ->where('day_of_week', $dayOfWeek)
            ->where('start_time', '<=', $data['start_time'])
            ->where('end_time', '>=', $data['end_time'])
            ->exists();

        if (! $scheduleExists) {
            return response()->json([
                'message' => 'El médico no tiene disponibilidad en el día u horario seleccionado.',
                'errors'  => [
                    'appointment_date' => ["El médico no tiene agenda los {$dayOfWeek}."],
                    'start_time'       => ['El bloque horario solicitado no está dentro del horario del médico.'],
                ],
            ], 422);
        }

        // 3. Rechazar cita duplicada: mismo médico + misma fecha + misma hora de inicio
        $duplicateExists = Appointment::where('doctor_id', $data['doctor_id'])
            ->where('appointment_date', $data['appointment_date'])
            ->where('start_time', $data['start_time'])
            ->exists();

        if ($duplicateExists) {
            return response()->json([
                'message' => 'Ya existe una cita para este médico en la misma fecha y horario.',
                'errors'  => [
                    'start_time' => ['El médico ya tiene una cita registrada en ese horario.'],
                ],
            ], 422);
        }

        // Crear la cita
        $appointment = Appointment::create([
            'patient_id'       => $data['patient_id'],
            'doctor_id'        => $data['doctor_id'],
            'appointment_date' => $data['appointment_date'],
            'start_time'       => $data['start_time'],
            'end_time'         => $data['end_time'],
            'status'           => 'programada',
            'visit_reason'     => $data['visit_reason'],
            'notes'            => $data['notes'] ?? null,
        ]);

        return response()->json([
            'message' => 'Cita creada correctamente.',
            'data'    => $appointment->load(['patient', 'doctor']),
        ], 201);
    }
}
