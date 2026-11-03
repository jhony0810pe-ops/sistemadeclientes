<!DOCTYPE html>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Celular</title>

```
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
```

</head>
<body>

<div class="container mt-5">

```
<h1 class="mb-4">Actualizar Celular</h1>

<form action="/celulares/actualizar/{{ $celular->id }}" method="POST">

    @csrf

    <div class="mb-3">
        <label class="form-label">Marca</label>
        <input type="text"
               name="marca"
               value="{{ $celular->marca }}"
               class="form-control"
               required>
    </div>

    <div class="mb-3">
        <label class="form-label">Modelo</label>
        <input type="text"
               name="modelo"
               value="{{ $celular->modelo }}"
               class="form-control"
               required>
    </div>

    <div class="mb-3">
        <label class="form-label">Precio</label>
        <input type="number"
               step="0.01"
               name="precio"
               value="{{ $celular->precio }}"
               class="form-control"
               required>
    </div>

    <div class="mb-3">
        <label class="form-label">Stock</label>
        <input type="number"
               name="stock"
               value="{{ $celular->stock }}"
               class="form-control"
               required>
    </div>

    <button type="submit" class="btn btn-primary">
        Actualizar
    </button>

    <a href="/celulares/listar" class="btn btn-secondary">
        Cancelar
    </a>

</form>
```

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
