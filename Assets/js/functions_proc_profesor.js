let tableProcProfesor;
let rowTable = ""; //variable que almacena el parametro this que va desde la funcion fntEditUsuario()
//let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function()
{
  	tableProcProfesor = $('#tableProcProfesor').dataTable({
		"aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/ProcProfesor/getProcesos",
            "dataSrc":""
        },
        "columns":[
            {"data":"proceso_id"},
            {"data":"nombre"},
            {"data":"nombre_grado"},
            {"data":"nombre_aula"},
            {"data":"nombre_materia"},
            {"data":"nombre_periodo"},
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

});

     function openModal()
    {
        rowTable = "";
        document.querySelector('#idprofesor').value ="";
        document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
        document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
        document.querySelector('#btnText').innerHTML = "Guardar";
        document.querySelector('#titleModal').innerHTML = "Nuevo Proceso";
        document.querySelector("#formProfesor").reset();
        $('#modalFormProfesor').modal('show');
    }

    window.addEventListener('load', function() {
       fntSelectProfesores();
       fntSelectGrados();
    }, false);


   if(document.querySelector("#formProfesor")){
        let formProfesor = document.querySelector('#formProfesor');
        formProfesor.onsubmit = function(e){
            e.preventDefault();
            let intProfesor = document.querySelector("#listProfesor").value;
            let intGrado = document.querySelector("#listGrado").value; 
            let intAula = document.querySelector("#listAula").value; 
            let intMateria = document.querySelector("#listMateria").value; 
            let intPeriodo = document.querySelector("#listPeriodo").value;
            let intStatus = document.querySelector("#listStatus").value;


            if (intProfesor == '' || intGrado == '' || intAula == '' || intMateria == '' || intPeriodo == '' || intProfesor == '' || intStatus == '')
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
            let ajaxUrl = base_url+'/ProcProfesor/setProceso';
            let formData = new FormData(formProfesor);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function()
            {
                if (request.readyState == 4 && request.status == 200)
                {
                    let objData = JSON.parse(request.responseText);
                    console.log(objData);
                    if (objData.status)
                    {
                        if(rowTable == "") //si no alamaceno la fila se esta creando un nuevo usuario y se regarga la fila 
                        {
                            //cuando se crea un grado
                            tableProcProfesor.api().ajax.reload();
                        }
                        else
                        {
                            //cuando se actualiza un grado
                             htmlStatus = intStatus == 1 ?
                            '<span class="badge badge-success">Activo</span>':
                            '<span class="badge badge-danger">Inactivo</span>';
                           // rowTable.cells[1].textContent = strNombres;
                            //rowTable.cells[2].innerHTML = htmlStatus;
                        }
                        $('#modalFormProfesor').modal("hide");
                        formProfesor.reset();
                        swal("Proceso Profesor", objData.msg, "success");
                    }
                    else 
                    {
                        swal("Error", objData.msg, "error");
                    }
                }
            }
        }
    }  

    function fntViewActividad(idactividad)
    {
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Actividades/getActividad/'+idactividad;
        request.open("GET",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200)
            {
                let objData = JSON.parse(request.responseText);
                if (objData.status)
                {
                    let estadoActividad = objData.data.estado == 1 ?
                     '<span class="badge badge-success">Activo</span>' :
                     '<span class="badge badge-danger">Inactivo</span>';

                     document.querySelector("#celNombre").innerHTML = objData.data.nombre_actividad;
                     document.querySelector("#celEstado").innerHTML = estadoActividad;
                     $('#modalViewActividad').modal('show');
                }
                else
                {
                    swal("Error",objData.msg, "error");
                }
            }
        }
    }
    // element recibe el parametro this enviado desde el boton en js, que en realidad viene siendo toda la info del boton 
    function fntEditActividad(element,idactividad)
    {
        // se accede desde el boton editar usuario a toda esa fila donde se encuetra ese boton por medio de parentNode
        rowTable = element.parentNode.parentNode.parentNode;
        //rowTable.cells[1].textContent = "julio";
        //console.log(rowTable);
        document.querySelector('#titleModal').innerHTML = "Actualizar Actividad";
        document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
        document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
        document.querySelector('#btnText').innerHTML ="Actualizar";
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest(): new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Actividades/getActividad/'+idactividad;
        request.open("GET",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){

            if(request.readyState == 4 && request.status == 200)
            {
                let objData = JSON.parse(request.responseText);
                //console.log(objData);

                if(objData.status)
                {
                    document.querySelector('#idActividad').value = objData.data.actividad_id;
                    document.querySelector('#txtNombre').value = objData.data.nombre_actividad;
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
            $('#modalFormActividad').modal('show');
        }
    }

    function fntDelActividad(idactividad)
    {
        swal({
            title: "Eliminar Actividad",
            text: "Realmente quiere eliminar la Actividad ?", 
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
                let ajaxUrl = base_url+'/Actividades/delActividad';
                let strData = "idActividad="+idactividad;
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
                            tableActividades.api().ajax.reload();
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

    function fntSelectProfesores()
    {
        if (document.querySelector('#listProfesor'))
        {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/ProcProfesor/getSelectProfesores';
            request.open("GET",ajaxUrl,true);
            request.send();
            request.onreadystatechange = function(){
                if (request.readyState == 4 && request.status == 200){
                    document.querySelector('#listProfesor').innerHTML = request.responseText;
                    $('#listProfesor').selectpicker('render');
                }
            }

        }
    }

    function fntSelectGrados()
    {
         if (document.querySelector('#listGrado'))
        {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/ProcProfesor/getSelectGrados';
            request.open("GET",ajaxUrl,true);
            request.send();
            request.onreadystatechange = function(){
                if (request.readyState == 4 && request.status == 200){
                    document.querySelector('#listGrado').innerHTML = request.responseText;
                    $('#listGrado').selectpicker('render');
                }
            }

        }
    }


  /*  window.addEventListener('load',function(){
        fntSelectAulas()
    },false); */

 /*   function fntSelectAulas()
    {
        if (document.querySelector('#listAula'))
        {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/ProcProfesor/getSelectAulas';
            request.open("GET",ajaxUrl,true);
            request.send();
            request.onreadystatechange = function(){
                //console.log(request.responseText);
                if (request.readyState == 4 && request.status == 200){
                   let objData = JSON.parse(request.responseText);
                   console.log(objData);
                    if(objData.status)
                        {
                            objData.data.forEach(function(valor)
                            {
                                objData += '<option value="'+valor.aula_id+'">'+valor.nombre_aula+'</option>';
                            });
                        }
                            
                        document.querySelector("#listAula").innerHTML = objData;
                }
            }

        }
    } */


   







