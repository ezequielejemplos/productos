<?php

require("productos.php");

$producto = new Producto();

if($_REQUEST)
{
    if(isset($_POST["enviar"]))
    {
        if($_FILES["file"]["error"] === UPLOAD_ERR_OK)
        {
            $rand = uniqid();
            $file = $_FILES["file"]["tmp_name"];
            $imagen = $rand . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
            move_uploaded_file($file, "images/" . $imagen);
            unlink("images/" . $_GET["imagen"]);
        }
        else
        {
            $imagen = $_GET["imagen"];
        }
        $producto->id = $_GET["id"];
        $producto->nombre = $_POST["nombre"];
        $producto->precio = $_POST["precio"];
        $producto->agotado = $_POST["agotado"];
        $producto->comentario = $_POST["comentario"];
        $producto->imagen = $imagen;
        $producto->editar();
        header("location: index.php");
    }
    if(isset($_GET["id"]) && isset($_GET["imagen"]))
    {
        $producto->id = $_GET["id"];
        $producto->obtenerPorId();
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta nombre="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <!---->
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <!---->
    <section>
        <div class="container">
            <br>
            <div class="row">
                <div class="col-12 col-md-6 offset-md-3 col-lg-4 offset-lg-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data">
                                <div>
                                    <label class="form-label">Nombre</label>
                                    <input type="text" class="form-control" name="nombre" value="<?php echo $producto->nombre; ?>" required>
                                </div>
                                <br>
                                <div>
                                    <label class="form-label">Precio</label>
                                    <input type="number" step="any" class="form-control" name="precio" value="<?php echo $producto->precio; ?>" required>
                                </div>
                                <br>
                                <div>
                                    <label class="form-label">Agotado</label>
                                    <select name="agotado" class="form-select" required>
                                        <option value="<?php echo $producto->agotado; ?>">Actual</option>
                                        <option value="0">No</option>
                                        <option value="1">Si</option>
                                    </select>
                                </div>
                                <br>
                                <textarea class="form-control" name="comentario" cols="30" rows="4" placeholder="Comentario"><?php echo $producto->comentario; ?></textarea>
                                <br>
                                <input type="file" class="form-control" name="file">
                                <br>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-dark" name="enviar">Enviar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>