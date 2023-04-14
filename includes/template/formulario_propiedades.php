
<fieldset>
    <legend>Información general</legend>

    <label for="titulo">Titulo:</label>
    <input type="text" id="titulo" name="titulo" placeholder="Titulo propiedad" value="<?php echo sanitizarHTML($propiedad->titulo) ?>">

    <label for="precio">Precio:</label>
    <input type="number" id="precio" name="precio" placeholder="Precio propiedad" value="<?php echo sanitizarHTML($propiedad->precio) ?>">
    
    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

    <?php if ($propiedad->imagen): ?>
        <img src="/imagenes/<?php echo ($propiedad->imagen) ?>" class="imagen-small" alt="imagen propiedad">
    <?php endif; ?>

    <label for="descripcion">Descripción</label>
    <textarea id="descripcion" name="descripcion"><?php echo sanitizarHTML(trim($propiedad->descripcion)) ?></textarea>
</fieldset>

<fieldset>
    <legend>Información propiedad</legend>

    <label for="habitaciones">Habitaciones:</label>
    <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 3" min="1" max="9" value="<?php echo sanitizarHTML($propiedad->habitaciones) ?>">

    <label for="wc">Baños:</label>
    <input type="number" name="wc" id="wc" placeholder="Ej: 3" min="1" max="9" value="<?php echo sanitizarHTML($propiedad->wc) ?>">
    
    <label for="estacionamiento">Estacionamientos:</label>
    <input type="number" name="estacionamiento" id="estacionamiento" placeholder="Ej: 3" min="1" max="9" value="<?php echo sanitizarHTML($propiedad->estacionamiento) ?>">
</fieldset>

<fieldset>
    <legend>Vendedor</legend>

    <select name="vendedorId">

        <option value="">-- Seleccione --</option>
        <?php foreach ($vendedores as $vendedor): ?>
            <option value="<?php echo sanitizarHTML($vendedor->id); ?>" <?php echo ($vendedor->id === $propiedad->vendedorId) ? "selected" : ""; ?> >
                <?php echo "{$vendedor->nombre}  {$vendedor->apellido}"; ?>
            </option>
        <?php endforeach ?>

    </select>
</fieldset>