<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_id'       => ['required', 'integer', 'exists:patients,id'],
            'doctor_id'        => ['required', 'integer', 'exists:users,id'],
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
            'start_time'       => ['required', 'date_format:H:i'],
            'end_time'         => ['required', 'date_format:H:i', 'after:start_time'],
            'visit_reason'     => ['required', 'string', 'max:500'],
            'notes'            => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'patient_id.required'            => 'El paciente es obligatorio.',
            'patient_id.exists'              => 'El paciente seleccionado no existe.',
            'doctor_id.required'             => 'El médico es obligatorio.',
            'doctor_id.exists'               => 'El médico seleccionado no existe.',
            'appointment_date.required'      => 'La fecha de la cita es obligatoria.',
            'appointment_date.date'          => 'La fecha de la cita no tiene un formato válido.',
            'appointment_date.after_or_equal'=> 'La fecha de la cita no puede ser en el pasado.',
            'start_time.required'            => 'La hora de inicio es obligatoria.',
            'start_time.date_format'         => 'La hora de inicio debe tener el formato HH:MM.',
            'end_time.required'              => 'La hora de fin es obligatoria.',
            'end_time.date_format'           => 'La hora de fin debe tener el formato HH:MM.',
            'end_time.after'                 => 'La hora de fin debe ser posterior a la hora de inicio.',
            'visit_reason.required'          => 'El motivo de la visita es obligatorio.',
        ];
    }
}
