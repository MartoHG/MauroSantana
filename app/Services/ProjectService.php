<?php

namespace App\Services;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProjectService
{
    /**
     * Crea un proyecto: guarda el PDF, su hash, la imagen (opcional) y genera el QR.
     *
     * @param  array<string, mixed>  $attributes  Campos ya validados (sin archivos).
     */
    public function create(array $attributes, UploadedFile $pdf, ?UploadedFile $imagen, User $owner): Project
    {
        $hash = hash_file('sha256', $pdf->getRealPath());
        $pdfPath = $this->storePdf($pdf);

        return Project::create([
            ...$attributes,
            'pdf_path' => $pdfPath,
            'pdf_hash' => $hash,
            'imagen_path' => $imagen ? $this->storeImage($imagen) : null,
            'qr_path' => $this->generateQr($pdfPath),
            'user_id' => $owner->id,
        ]);
    }

    /**
     * Actualiza un proyecto. Solo reemplaza archivos (y regenera el QR) si se
     * suben nuevos, borrando siempre los anteriores.
     *
     * @param  array<string, mixed>  $attributes  Campos ya validados (sin archivos).
     */
    public function update(Project $project, array $attributes, ?UploadedFile $pdf, ?UploadedFile $imagen): Project
    {
        if ($imagen) {
            $this->deleteFile($project->imagen_path);
            $attributes['imagen_path'] = $this->storeImage($imagen);
        }

        if ($pdf) {
            $this->deleteFile($project->pdf_path);
            $this->deleteFile($project->qr_path);

            $attributes['pdf_hash'] = hash_file('sha256', $pdf->getRealPath());
            $attributes['pdf_path'] = $this->storePdf($pdf);
            $attributes['qr_path'] = $this->generateQr($attributes['pdf_path']);
        }

        $project->update($attributes);

        return $project;
    }

    /**
     * Elimina un proyecto y todos sus archivos asociados.
     */
    public function delete(Project $project): void
    {
        $this->deleteFile($project->pdf_path);
        $this->deleteFile($project->qr_path);
        $this->deleteFile($project->imagen_path);

        $project->delete();
    }

    private function storePdf(UploadedFile $pdf): string
    {
        return $pdf->store('pdfs', 'public');
    }

    private function storeImage(UploadedFile $imagen): string
    {
        return $imagen->store('project_images', 'public');
    }

    /**
     * Genera el QR (SVG) apuntando al PDF público y lo guarda en el disco.
     */
    private function generateQr(string $pdfPath): string
    {
        $url = asset('storage/'.$pdfPath);
        $qrPath = 'qrs/qr_'.now()->timestamp.'_'.Str::random(6).'.svg';

        Storage::disk('public')->put(
            $qrPath,
            (string) QrCode::format('svg')->size(300)->generate($url),
        );

        return $qrPath;
    }

    private function deleteFile(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
