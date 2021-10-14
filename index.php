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
        }
        else
        {
            $imagen = "";
        }
        $producto->nombre = $_POST["nombre"];
        $producto->precio = $_POST["precio"];
        $producto->agotado = $_POST["agotado"];
        $producto->comentario = $_POST["comentario"];
        $producto->imagen = $imagen;
        $producto->nuevo();
    }
    if(isset($_GET["borrar"]) && isset($_GET["id"]) && isset($_GET["imagen"]))
    {
        $producto->id = $_GET["id"];
        $producto->borrar();
        unlink("images/" . $_GET["imagen"]);
        header("location: index.php");
    }
}

$productos = new Producto();
$productos = $productos->obtenerTodo();

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
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data">
                                <div>
                                    <label class="form-label">Nombre</label>
                                    <input type="text" class="form-control" name="nombre" required>
                                </div>
                                <br>
                                <div>
                                    <label class="form-label">Precio</label>
                                    <input type="number" step="any" class="form-control" name="precio" required>
                                </div>
                                <br>
                                <div>
                                    <label class="form-label">Agotado</label>
                                    <select name="agotado" class="form-select" required>
                                        <option value="0">No</option>
                                        <option value="1">Si</option>
                                    </select>
                                </div>
                                <br>
                                <textarea class="form-control" name="comentario" cols="30" rows="4" placeholder="Comentario"></textarea>
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
                <div class="col-12 col-md-6 col-lg-8">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover border">
                            <tr>
                                <td>Id</td>
                                <td>Nombre</td>
                                <td>Precio</td>
                                <td>Estado</td>
                                <td>Comentario</td>
                                <td>Imagen</td>
                                <td></td>
                                <td></td>
                            </tr>

                            <?php foreach($productos as $i): ?>

                            <tr>
                                <td><?php echo $i->id; ?></td>
                                <td><?php echo $i->nombre; ?></td>
                                <td><?php echo $i->precio; ?></td>

                                <?php
                                
                                if ($i->agotado == 0) {
                                    $color = "table-success";
                                    $estado = "Disponible";
                                }
                                else {
                                    $color = "table-danger";
                                    $estado = "Agotado";
                                }

                                ?>

                                <td class="<?php echo $color; ?>"><?php echo $estado; ?></td>

                                <td><?php echo $i->comentario; ?></td>
                                <td>
                                    <img src="images/<?php echo $i->imagen; ?>" class="img-fluid rounded" width="70">
                                </td>
                                <td>
                                    <a href="editar.php?id=<?php echo $i->id; ?>&imagen=<?php echo $i->imagen; ?>" class="btn btn-link">Editar</a>
                                </td>
                                <td>
                                    <a href="index.php?borrar&id=<?php echo $i->id; ?>&imagen=<?php echo $i->imagen; ?>" class="btn btn-link">Borrar</a>
                                </td>
                            </tr>

                            <?php endforeach; ?>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>