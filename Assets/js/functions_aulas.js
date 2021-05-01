let tableAulas;
let rowTable = ""; //variable que almacena el parametro this que va desde la funcion fntEditUsuario()
//let divLoading = document.querySelector("#divLoading");

document.addEventListener('DOMContentLoaded', function()
{
	tableAulas = $('#tableAulas').dataTable({
		"aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Aulas/getAulas",
            "dataSrc":""
        },
        "columns":[
            {"data":"aula_id"},
            {"data":"nombre_aula"},
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

   // fntRolesUsuario();

});

   if(document.querySelector("#formAula")){
        let formAula = document.querySelector('#formAula');
        formAula.onsubmit = function(e){
            e.preventDefault();
            let strNombres = document.querySelector("#txtNombre").value;
            let intStatus = document.querySelector("#listStatus").value;


            if (strNombres == ''  || intStatus == '')
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
            let ajaxUrl = base_url+'/Aulas/setAulas';
            let formData = new FormData(formAula);
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
                            tableAulas.api().ajax.reload();
                        }
                        else
                        {
                            //cuando se actualiza un grado
                             htmlStatus = intStatus == 1 ?
                            '<span class="badge badge-success">Activo</span>':
                            '<span class="badge badge-danger">Inactivo</span>';
                            rowTable.cells[1].textContent = strNombres;
                            rowTable.cells[2].innerHTML = htmlStatus;
                        }
                        $('#modalFormAula').modal("hide");
                        formAula.reset();
                        swal("Aulas", objData.msg, "success");
                    }
                    else 
                    {
                        swal("Error", objData.msg, "error");
                    }
                }
            }
        }
    }  

    function fntViewAula(idaula)
    {
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Aulas/getAula/'+idaula;
        request.open("GET",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200)
            {
                let objData = JSON.parse(request.responseText);
                if (objData.status)
                {
                    let estadoAula = objData.data.estado == 1 ?
                     '<span class="badge badge-success">Activo</span>' :
                     '<span class="badge badge-danger">Inactivo</span>';

                     document.querySelector("#celNombre").innerHTML = objData.data.nombre_aula;
                     document.querySelector("#celEstado").innerHTML = estadoAula;
                     $('#modalViewAula').modal('show');
                }
                else
                {
                    swal("Error",objData.msg, "error");
                }
            }
        }
    }
    // element recibe el parametro this enviado desde el boton en js, que en realidad viene siendo toda la info del boton 
    function fntEditAula(element,idaula)
    {
        // se accede desde el boton editar usuario a toda esa fila donde se encuetra ese boton por medio de parentNode
        rowTable = element.parentNode.parentNode.parentNode;
        //rowTable.cells[1].textContent = "julio";
        //console.log(rowTable);
        document.querySelector('#titleModal').innerHTML = "Actualizar Aula";
        document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
        document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
        document.querySelector('#btnText').innerHTML ="Actualizar";
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest(): new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Aulas/getAula/'+idaula;
        request.open("GET",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){

            if(request.readyState == 4 && request.status == 200)
            {
                let objData = JSON.parse(request.responseText);
                //console.log(objData);

                if(objData.status)
                {
                    document.querySelector('#idAula').value = objData.data.aula_id;
                    document.querySelector('#txtNombre').value = objData.data.nombre_aula;
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
            $('#modalFormAula').modal('show');
        }
    }

    function fntDelAula(idaula)
    {
        swal({
            title: "Eliminar Aula",
            text: "Realmente quiere eliminar el Aula ?", 
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
                let ajaxUrl = base_url+'/Aulas/delAula';
                let strData = "idAula="+idaula;
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
                            tableAulas.api().ajax.reload();
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
        document.querySelector('#idAula').value ="";
        document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
        document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
        document.querySelector('#btnText').innerHTML = "Guardar";
        document.querySelector('#titleModal').innerHTML = "Nueva Aula";
        document.querySelector("#formAula").reset();
        $('#modalFormAula').modal('show');

    }







