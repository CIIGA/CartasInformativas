<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class ArchivoController extends Controller
{
    
    public function index($idPlaza)
    {
        try {
            // Verificar si existe la imagen de la plaza
            $rutaImagen = public_path('img/plazas/' . $idPlaza . '.jpg'); // Suponemos que las imágenes son archivos JPG
            if (!file_exists($rutaImagen)) {
                // return response()->json(['error' => 'No se encontró la imagen para la plaza seleccionada.'], 404);
                // Obtener el contenido de la imagen por defecto
                $rutaImagen = public_path('img/plazas/default.jpg');
            }
    
            // Obtener el contenido de la imagen
            $contenidoImagen = file_get_contents($rutaImagen);
    
            // Devolver la imagen con la cabecera adecuada para que se muestre correctamente
            return Response::make($contenidoImagen, 200, ['Content-Type' => 'image/jpg']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ha ocurrido un error al obtener la imagen.'], 500);
        }
    }
    


    public function store(Request $request)
    {
        try {
            // Validar el archivo y guardarlo en la carpeta "public/img/plazas"
            if ($request->hasFile('archivo') && $request->file('archivo')->isValid()) {
                $archivo = $request->file('archivo');
                // Verificar que el archivo sea una imagen JPG
                if ($archivo->getClientOriginalExtension() !== 'jpg') {
                    return response()->json(['error' => 'El archivo debe ser de tipo JPG.'], 400);
                }
            
                $plazaId = $request->input('plaza_id');
                $extension = $archivo->getClientOriginalExtension();
                $nombreArchivo = $plazaId . '.' . $extension;
                $nombreArchivo = str_replace(' ', '_', $nombreArchivo); // Reemplazar espacios en blanco con guiones bajos
                $rutaArchivo = public_path('img/plazas/' . $nombreArchivo);
            
                // Verificar si ya existe un archivo con el mismo nombre
                if (file_exists($rutaArchivo)) {
                    // Eliminar el archivo existente antes de reemplazarlo con el nuevo
                    unlink($rutaArchivo);
                }
            
                // Mover el archivo al directorio public_path
                $archivo->move(public_path('img/plazas'), $nombreArchivo);
            
                // Verificar si el archivo se ha guardado correctamente
                if (file_exists($rutaArchivo) && is_file($rutaArchivo)) {
                    // return redirect()->action([IndexController::class, 'index'])->with('subirImagen', 'success');

                    return response()->json(['success' => 'Archivo subido y guardado correctamente.']);
                } else {
                    return response()->json(['error' => 'No se pudo guardar el archivo correctamente.'], 500);
                }
            } else {
                return response()->json(['error' => 'Archivo inválido o no se proporcionó ningún archivo.'], 400);
            }
            
        } catch (\Exception $e) {
            // Manejar el error y devolver una respuesta con código 500 (Internal Server Error)
            return response()->json(['error' => 'Ha ocurrido un error al guardar el archivo.'], 500);
        }
    }
}
