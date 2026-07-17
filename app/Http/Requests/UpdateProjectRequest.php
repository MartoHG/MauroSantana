<?php

namespace App\Http\Requests;

use App\Models\Project;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
{
    /**
     * Solo quien puede gestionar proyectos edita este proyecto.
     */
    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->route('project')) ?? false;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'titulo' => [
                'required',
                'string',
                'max:255',
                Rule::unique('projects')
                    ->where(fn ($query) => $query->where('tipo', $this->input('tipo')))
                    ->ignore($this->route('project')->id),
            ],
            'tipo' => ['required', 'in:Proyecto,Ordenanza'],
            'categoria' => ['required', 'string'],
            'fecha' => ['required', 'date'],
            'descripcion' => ['nullable', 'string'],
            'pdf' => ['nullable', 'mimes:pdf', 'max:20480'],
            'imagen' => ['nullable', 'image', 'max:10240'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'titulo.unique' => 'Ya existe otro documento de tipo "'.$this->input('tipo').'" con este título.',
        ];
    }

    /**
     * Control de duplicados de PDF por hash, ignorando el proyecto actual.
     * Solo aplica cuando se sube un PDF nuevo.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if (! $this->hasFile('pdf') || ! $this->file('pdf')->isValid()) {
                return;
            }

            $hash = hash_file('sha256', $this->file('pdf')->getRealPath());

            $duplicate = Project::where('pdf_hash', $hash)
                ->where('tipo', $this->input('tipo'))
                ->where('id', '!=', $this->route('project')->id)
                ->first();

            if ($duplicate) {
                $validator->errors()->add(
                    'pdf',
                    'Este archivo PDF ya existe en otro proyecto: "'.$duplicate->titulo.'".'
                );
            }
        });
    }
}
