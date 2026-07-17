<?php

namespace App\Http\Requests;

use App\Models\Project;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProjectRequest extends FormRequest
{
    /**
     * Solo quien puede gestionar proyectos crea uno nuevo.
     */
    public function authorize(): bool
    {
        return $this->user()?->can('create', Project::class) ?? false;
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
                Rule::unique('projects')->where(fn ($query) => $query->where('tipo', $this->input('tipo'))),
            ],
            'tipo' => ['required', 'in:Proyecto,Ordenanza'],
            'categoria' => ['required', 'string'],
            'fecha' => ['required', 'date'],
            'descripcion' => ['nullable', 'string'],
            'pdf' => ['required', 'mimes:pdf', 'max:20480'],
            'imagen' => ['nullable', 'image', 'max:10240'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'titulo.unique' => 'Ya existe un documento de tipo "'.$this->input('tipo').'" con este título exacto.',
        ];
    }

    /**
     * Control de duplicados de PDF por hash: el mismo archivo no puede
     * subirse dos veces dentro del mismo tipo de documento.
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
                ->first();

            if ($duplicate) {
                $validator->errors()->add(
                    'pdf',
                    'Este archivo PDF ya fue subido anteriormente en el proyecto: "'.$duplicate->titulo.'".'
                );
            }
        });
    }
}
