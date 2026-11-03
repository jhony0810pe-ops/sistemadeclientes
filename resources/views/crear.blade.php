<!DOCTYPE html>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Celular</title>

```
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
```

</head>
<body>

<div class="container mt-5">

```
<h1 class="mb-4">Registrar Celular</h1>

<form action="/celulares/guardar" method="POST">

    @csrf

    <div class="mb-3">
        <label class="form-label">Marca</label>
        <input type="text" name="marca" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Modelo</label>
        <input type="text" name="modelo" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Precio</label>
        <input type="number" step="0.01" name="precio" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Stock</label>
        <input type="number" name="stock" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">
        Guardar
    </button>

    <a href="/celulares/listar" class="btn btn-secondary">
        Volver
    </a>

</form>
```

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
