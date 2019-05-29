//override the render method on app/Exceptions/Handler.php 

// Don't forget this in the beginning of file
use Illuminate\Database\Eloquent\ModelNotFoundException;

// ...

public function render($request, Exception $exception)
{
    if ($exception instanceof ModelNotFoundException) {
        return response()->json([
            'error' => 'Entry for '.str_replace('App\\', '', $exception->getModel()).' not found'], 404);
    }

    return parent::render($request, $exception);
}