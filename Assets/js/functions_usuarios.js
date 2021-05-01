let tableUsuarios;
let rowTable = ""; //variable que almacena el parametro this que va desde la funcion fntEditUsuario()
//let divLoading = document.querySelector("#divLoading");

document.addEventListener('DOMContentLoaded', function()
{
	tableUsuarios = $('#tableUsuarios').dataTable({
		"aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Usuarios/getUsuarios",
            "dataSrc":""
        },
        "columns":[
            {"data":"usuario_id"},
            {"data":"nombre"},
            {"data":"usuario"},
            {"data":"nombre_rol"},
            {"data":"estado"},
            {"data":"options"}
        ],

        'dom': 'lBfrtip',
        'buttons': [
            {
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i> Copiar",
                "titleAttr":"Copiar",
                "className": "btn btn-secondary"
            },{
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr":"Esportar a Excel",
                "className": "btn btn-success"
            },{
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr":"Esportar a PDF",
                "className": "btn btn-danger"
            },{
                "extend": "csvHtml5",
                "text": "<i class='fas fa-file-csv'></i> CSV",
                "titleAttr":"Esportar a CSV",
                "className": "btn btn-info"
            }
        ],
        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 3,
        "order":[[0,"desc"]]  
	});

    fntRolesUsuario();

});

   if(document.querySelector("#formUsuario")){
        let formUsuario = document.querySelector('#formUsuario');
        formUsuario.onsubmit = function(e){
            e.preventDefault();
            let strNombres = document.querySelector("#txtNombre").value;
            let strUsuario = document.querySelector("#txtUsuario").value;
            let strPassword = document.querySelector("#txtPassword").value;
            let intTipousuario = document.querySelector("#listRolid").value;
            let intStatus = document.querySelector("#listStatus").value;

            if (strNombres == '' || strUsuario == '' || intTipousuario == '' || intStatus == '')
            {

                swal("Atencion", "Todos los campos son obligatorios.", "error");
                return false;
            }

            let elementsValid = document.getElementsByClassName("valid");
            for (let i = 0; i < elementsValid.length; i++)
            {
                if (elementsValid[i].classList.contains('is-invalid'))
                {
                    swal("Atencion", "Por favor verifique los campos en rojo." , "error");
                    return false;
                }
            }
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Usuarios/setUsuario';
            let formData = new FormData(formUsuario);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function()
            {
                if (request.readyState == 4 && request.status == 200)
                {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status)
                    {
                        if(rowTable == "") //si no alamaceno la fila se esta creando un nuevo usuario y se regarga la fila 
                        {
                            //cuando se crea un usuario
                            tableUsuarios.api().ajax.reload();
                        }
                        else
                        {
                            //cuando se actualiza un usuario
                            htmlStatus = intStatus == 1 ?
                            '<span class="badge badge-success">Activo</span>':
                            '<span class="badge badge-danger">Inactivo</span>';
                            rowTable.cells[1].textContent = strNombres;
                            rowTable.cells[2].textContent = strUsuario;
                            rowTable.cells[3].textContent = document.querySelector("#listRolid").selectedOptions[0].text;
                            rowTable.cells[4].innerHTML = htmlStatus;
                        }
                        $('#modalFormUsuario').modal("hide");
                        formUsuario.reset();
                        swal("Usuarios", objData.msg, "success");
                    }
                    else 
                    {
                        swal("Error", objData.msg, "error");
                    }
                }
            }
        }
    }  

   if(document.querySelector("#formPerfil")){
        let formPerfil = document.querySelector("#formPerfil");
        formPerfil.onsubmit = function(e){
            e.preventDefault();
            let strNombres = document.querySelector('#txtNombre').value;
            //let strUsuario = document.querySelector('#txtUsuario').value;
            let strPassword = document.querySelector('#txtPassword').value;
            let strPasswordConfirm = document.querySelector('#txtPasswordConfirm').value;

            if (strNombres == "")
            {
                swal("Atencion", "Todos los campos son obligatorios.", "error");
                return false;
            }

            if(strPassword != "" || strPasswordConfirm != "")
            {
                if (strPassword != strPasswordConfirm)
                {
                    swal("Atención", "Las contraseñas no son iguales.", "info" );
                    return false;
                }
                if(strPassword.length < 5)
                {
                   swal("Atención", "La contraseña debe tener un minimo de 5 caracteres.", "info");
                   return false;
                }
            }

            let elementsValid = document.getElementsByClassName("valid");
            for(let i = 0; i < elementsValid.length; i++)
            {
                if (elementsValid[i].classList.contains('is-invalid')) 
                {
                    swal("Atención", "Por favor verifique los campos en rojo.", "error");
                    return false;
                }
            }
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Usuarios/putPerfil';
            let formData = new FormData(formPerfil);
            request.open('POST',ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if (request.readyState != 4) return;
                if (request.status == 200)
                {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status)
                    {
                        $('#modalFormPerfil').modal("hide");
                        swal({
                            title: "",
                            text: objData.msg,
                            type: "success",
                            confirmButtonText: "Aceptar",
                            closeOnConfirm: false,
                        }, function(isConfirm)
                        {
                            if (isConfirm)
                            {
                                location.reload();
                            }
                        });
                    }
                    else
                    {
                        swal("Error", objData.msg , "error");
                    }
                }
            }
        }
   }

    function fntRolesUsuario()
    {
        if (document.querySelector('#listRolid'))
        {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Roles/getSelectRoles';
            request.open("GET",ajaxUrl,true);
            request.send();
            request.onreadystatechange = function(){
                if (request.readyState == 4 && request.status == 200){
                    document.querySelector('#listRolid').innerHTML = request.responseText;
                    $('#listRolid').selectpicker('render');
                }
            }

        }
    }

    function fntViewUsuario(idusuario)
    {
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Usuarios/getUsuario/'+idusuario;
        request.open("GET",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200)
            {
                let objData = JSON.parse(request.responseText);
                if (objData.status)
                {
                    let estadoUsuario = objData.data.estado == 1 ?
                     '<span class="badge badge-success">Activo</span>' :
                     '<span class="badge badge-danger">Inactivo</span>';

                     document.querySelector("#celNombre").innerHTML = objData.data.nombre;
                     document.querySelector("#celUsuario").innerHTML = objData.data.usuario;
                     document.querySelector("#celTipoUsuario").innerHTML = objData.data.nombre_rol;
                     document.querySelector("#celEstado").innerHTML = estadoUsuario;
                     $('#modalViewUser').modal('show');
                }
                else
                {
                    swal("Error",objData.msg, "error");
                }
            }
        }
    }
    // element recibe el parametro this enviado desde el boton en js, que en realidad viene siendo toda la info del boton 
    function fntEditUsuario(element,idusuario)
    {
        // se accede desde el boton editar usuario a toda esa fila donde se encuetra ese boton por medio de parentNode
        rowTable = element.parentNode.parentNode.parentNode;
        //rowTable.cells[1].textContent = "julio";
        //console.log(rowTable);
        document.querySelector('#titleModal').innerHTML = "Actualizar Usuario";
        document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
        document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
        document.querySelector('#btnText').innerHTML ="Actualizar";
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest(): new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Usuarios/getUsuario/'+idusuario;
        request.open("GET",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){

            if(request.readyState == 4 && request.status == 200)
            {
                let objData = JSON.parse(request.responseText);

                if(objData.status)
                {
                    document.querySelector('#idUsuario').value = objData.data.usuario_id;
                    document.querySelector('#txtNombre').value = objData.data.nombre;
                    document.querySelector('#txtUsuario').value = objData.data.usuario;
                    //document.querySelector('#txtPassword').value = objData.data.clave;
                    document.querySelector('#listRolid').value = objData.data.idrol;
                    $('#listRolid').selectpicker('render');

                    if(objData.data.estado == 1)
                    {
                        document.querySelector("#listStatus").value = 1;
                    }
                    else
                    {
                        document.querySelector("#listStatus").value = 2;
                    }
                    $('#listStatus').selectpicker('render');
                }
            }
            $('#modalFormUsuario').modal('show');
        }
    }

    function fntDelUsuario(idusuario)
    {
        swal({
            title: "Eliminar Usuario",
            text: "Realmente quiere eliminar el Usuario",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, eliminar!",
            cancelButtonText: "No, cancelar",
            closeOnConfirm: false,
            closeOnCancel:true
        }, function(isConfirm){

            if (isConfirm)
            {
                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let ajaxUrl = base_url+'/Usuarios/delUsuario';
                let strData = "idUsuario="+idusuario;
                request.open("POST",ajaxUrl,true);
                request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                request.send(strData);
                request.onreadystatechange = function()
                {
                    if (request.readyState == 4 && request.status == 200)
                    {
                        let objData = JSON.parse(request.responseText);
                        if(objData.status)
                        {
                            swal("Eliminar!", objData.msg, "success");
                            tableUsuarios.api().ajax.reload();
                        }
                        else
                        {
                            swal("Atencion!", objData.msg, "error");
                        }
                    }
                }
            }
        });
    }

    function openModal()
    {
        rowTable = "";
        document.querySelector('#idUsuario').value ="";
        document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
        document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
        document.querySelector('#btnText').innerHTML = "Guardar";
        document.querySelector('#titleModal').innerHTML = "Nuevo Usuario";
        document.querySelector("#formUsuario").reset();
        $('#modalFormUsuario').modal('show');

    }

    function openModalPerfil()
    {
        $('#modalFormPerfil').modal('show');
    }






