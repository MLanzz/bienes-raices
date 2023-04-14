<fieldset>
    <legend>Información vendedor</legend>

    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" placeholder="Nombre" value="<?php echo sanitizarHTML($vendedor->nombre) ?>">
    
    <label for="apellido">Apellido:</label>
    <input type="text" id="apellido" name="apellido" placeholder="Apellido" value="<?php echo sanitizarHTML($vendedor->apellido) ?>">
</fieldset>
<fieldset>
    <legend>Información de contacto</legend>
    
    <label for="email">E-Mail</label>
    <input type="email" id="email" name="email" placeholder="E-Mail" value="<?php echo sanitizarHTML($vendedor->email) ?>">

    <label for="telefono">Telefono:</label>
    <input type="tel" id="telefono" name="telefono" placeholder="Telefono" value="<?php echo sanitizarHTML($vendedor->telefono) ?>">

</fieldset>