<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Validar Usuario</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <form action="" autocomplete="off">
          <h3>Validar datos de usuario</h3>
          <hr>
          <div class="mb-3">
            <label for="user" class="form-label">Escriba nombre de usuario:</label>
            <div class="input-group">
              <input type="text" class="form-control" id="user">
              <button class="btn btn-success" type="button" id="buscar">Buscar</button>
              <button class="btn btn-primary" type="reset">Reiniciar</button>
            </div>
          </div>
          <!-- Respuestas -->
          <div class="mb-3">
            <div class="form-floating">
              <input type="text" class="form-control" id="datosuser" readonly="true">
              <label for="datosuser" class="form-label">Datos del usuario:</label>
            </div>
          </div>

          <div class="mb-3">
            <div class="form-floating">
              <input type="text" class="form-control" id="email" readonly="true">
              <label for="email" class="form-label">Correo electrónico:</label>
            </div>
          </div>

          <div class="text-end">
            <button class="btn btn-outline-dark" type="button" id="enviar">Enviar mensaje de restauracion</button>
          </div>

        </form>
      </div>
    </div>
  </div>

  <!-- Zona de modales -->
  <!-- Modal -->
  <div class="modal fade" id="modal-validacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog        ">
      <div class="modal-content">
        <div class="modal-header bg-primary text-light">
          <h5 class="modal-title" id="exampleModalLabel">Validar codigo</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="" autocomplete="off">
            <div class="form-floating">
              <input type="number" maxlength="4" class="form-control" id="clave">
              <label for="clave" class="form-label">Escriba la clave</label>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" id="comprobar">Comprobar</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

<script>
  document.addEventListener("DOMContentLoaded",() =>{

    //Variable para almacenar IDUSUARIO
    let idusuario = -1;

    // Objeto para manipular al modal
    const modal = new bootstrap.Modal(document.querySelector("#modal-validacion"));

    //abrir el modal
    document.querySelector("#enviar").addEventListener("click", ()=>{
      if(idusuario != -1){
        modal.toggle();
      }else{
        alert("Ingresar nombre de usuario");
        document.querySelector("#user").focus();
      }
    })

    function buscador(){
      let parametros = new URLSearchParams();
      parametros.set("operacion","searchUser")
      parametros.set("user",document.querySelector("#user").value)

      fetch(`./controllers/Usuario.controller.php`,{
        method:'POST',
        body:parametros

      })
        .then(respuesta => respuesta.text())
        .then(datos => {
          if(datos != ""){ 
            const registro = JSON.parse(datos)
             
            //Reenviando datos a formulario
            idusuario = registro.idusuario;
            document.querySelector("#datosuser").value = `${registro.apellidos} ${registro.nombres}`;
            document.querySelector("#email").value = registro.email;
          }else{
            alert("Usuario no encontrado");
            idusuario = -1;
            document.querySelector("#datosuser").value = '';
            document.querySelector("#email").value = '';
          }
        
        });

    }

    //Evento click para bóton
    document.querySelector("#buscar").addEventListener("click",buscador);

    //Evento keypress(ENTER) caja de texto
    document.querySelector("#user").addEventListener("keypress",(key) =>{
      if(key.keyCode == 13){
        buscador();
      }
    })

  })
</script>

</body>
</html>