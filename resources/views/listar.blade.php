<!DOCTYPE html>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Celulares</title>

```
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
```

</head>
<body>

<div class="container mt-5">

```
<h1 class="mb-4">Lista de Celulares</h1>

<a href="/celulares/crear" class="btn btn-success mb-3">
    Nuevo Celular
</a>

<table class="table table-bordered table-striped">

    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>

    @foreach($celulares as $celular)

    <tr>
        <td>{{ $celular->id }}</td>
        <td>{{ $celular->marca }}</td>
        <td>{{ $celular->modelo }}</td>
        <td>${{ $celular->precio }}</td>
        <td>{{ $celular->stock }}</td>

        <td>

            <a href="/celulares/editar/{{ $celular->id }}"
               class="btn btn-warning btn-sm">
                Editar
            </a>

            <a href="/celulares/eliminar/{{ $celular->id }}"
               class="btn btn-danger btn-sm"
               onclick="return confirm('¿Eliminar este celular?')">
                Eliminar
            </a>

        </td>

    </tr>

    @endforeach

    </tbody>

</table>
```

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
