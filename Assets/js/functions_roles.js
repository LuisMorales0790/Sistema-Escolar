var tableRoles;
//var divLoading = document.querySelector('#divLoading');
document.addEventListener('DOMContentLoaded', function()
{
	tableRoles = $('#tableRoles').dataTable( {
	   	"aProcessing":true,
	   	"aServerSide":true,
	   	"language": {
	   			"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
	   	},
        "ajax":{
        	"url": " "+base_url+"/Roles/getRoles",
        	"dataSrc":""
        },
        "columns": [
            { "data": "idrol" },
            { "data": "nombre_rol" },
            { "data": "descripcion" },
            { "data": "status" },
            { "data": "options" }
        ],
        "responsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order":[[0,"desc"]]
    });

    //NUEVO ROL
    var formRol = document.querySelector("#formRol");
    formRol.onsubmit = function(e){
        e.preventDefault();

        var intIdrol = document.querySelector('#idRol').value;
        var strNombre = document.querySelector('#txtNombre').value;
        var strDescripcion = document.querySelector('#txtDescripcion').value;
        var intStatus = document.querySelector("#listStatus").value;
        if(strNombre == '' || strDescripcion == '' || intStatus == '')
        {
            swal("Atencion", "Todos los campos son obligatorios. ", "error");
            return false;
        }
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = base_url+'/Roles/setRol';
        var formData = new FormData(formRol);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
            if (request.readyState == 4 && request.status == 200){
                var objData = JSON.parse(request.responseText);
                //console.log(objData);
                if (objData.status){
                    $('#modalFormRol').modal("hide");
                    formRol.reset();
                    swal("Roles de usuario", objData.msg ,"success");
                    tableRoles.api().ajax.reload();
                }
                else
                {
                    swal("Error", objData.msg, "error");
                }
            }
            return false;
        }
    }


});

function fntEditRol(idrol){
    document.querySelector('#titleModal').innerHTML = "Actualizar Rol";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar Rol";

    var idrol = idrol;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'/Roles/getRol/'+idrol;
    request.open("GET",ajaxUrl ,true);
    request.send();

    request.onreadystatechange = function(){
        if (request.readyState == 4 && request.status == 200){
            var objData = JSON.parse(request.responseText);
            if (objData.status)
            {
                document.querySelector("#idRol").value = objData.data.idrol;
                document.querySelector("#txtNombre").value = objData.data.nombre_rol;
                document.querySelector("#txtDescripcion").value = objData.data.descripcion;

                if (objData.data.status == 1)
                {
                    var optionSelect = '<option value="1" selected class="notBlock">Activo</option>';  
                }
                else
                {
                    var optionSelect = '<option value="2" selected class="notBlock">Inactivo</option>';  
                }
                var htmlSelect = `${optionSelect}
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>
                                  `;
                document.querySelector("#listStatus").innerHTML = htmlSelect;
                $('#modalFormRol').modal('show');
            }
            else
            {
                swal("Error", objData.msg, "error");
            }
        }
    }
}

function fntDelRol(idrol)
{
    var idrol = idrol;
    swal({
        title: "Eliminar Rol",
        text: "¿Realmente quiere eliminar el Rol?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "No, cancelar!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm){

        if (isConfirm)
        {
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = base_url+'/Roles/delRol/';
            var strData = "idrol="+idrol;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if (request.readyState == 4 && request.status == 200){
                    var objData = JSON.parse(request.responseText);
                    if (objData.status) 
                    {
                        swal("Eliminar!", objData.msg, "success");
                        tableRoles.api().ajax.reload(function(){
                            
                        });
                    }else{
                        swal("Atencion!", objData.msg, "error");
                    }
                }
            }
        }

    });
}

function fntPermisos(idrol)
{

var idrol = idrol;
var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
var ajaxUrl = base_url+'/Permisos/getPermisosRol/'+idrol;
request.open("GET",ajaxUrl,true);
request.send(); 

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
        console.log(request.responseText);
                              //en la vista roles
        document.querySelector("#contentAjax").innerHTML = request.responseText;
        $('.modalPermisos').modal('show');
        document.querySelector('#formPermisos').addEventListener('submit',fntSavePermisos,false);
        }
    } 
} 

function fntSavePermisos(event){
    //evita que se recargue la pagina cuando demos un click en el boton guardar
    event.preventDefault();
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'/Permisos/setPermisos';
    var formElement = document.querySelector("#formPermisos");
    var formData = new FormData(formElement);
    request.open("POST",ajaxUrl,true);
    request.send(formData);

    request.onreadystatechange = function(){
        if (request.readyState == 4 && request.status == 200)
        {
            var objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                swal("Permisos de usuario", objData.msg, "success");
            }
            else
            {
                swal("Error", objData.msg, "error");

            }
        }
    }
}

function openModal()
{
    document.querySelector("#idRol").value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info","btn-primary");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Rol";
    document.querySelector('#formRol').reset();
	$('#modalFormRol').modal('show');
}