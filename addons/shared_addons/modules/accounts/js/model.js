// MODEL JS
// controller: accounts
// 


/**
 * Do ajax request for Index - table view
 * @param select_filter select object selector
 * @param input_filter input object selector
 * @param link URL to send query, responds HTML
 * success updates #table with new values
 */
function doAjaxQuery(select_filter, input_filter, link)
{

    var form_data = {
        f_type : select_filter.val(),  
        f_keywords: input_filter.val()                     
    };

    $.ajax({
        type: "POST",
        url: link,
        data: form_data,
        dataType: 'html',
        success: function(result){
            $('#btnCancel').attr('class','cancel btn orange');            
            //replace Table with new values 
            $('#indexTable').replaceWith(result);            
            // remove GIF
            $('#loader').remove();                          
        },
        error: function()
        {
            $('#loader').remove(); 
        }
    });         
}


function Datos()
{
    this.dia = "";
    this.desde = "";
    this.hasta = "";
    this.n = "";
}

function diaSemana(n)
{
    return weekday[n];
}

function VectoString()
{
    var txt="";
    for (var x in vec)
    {
        if(vec[x]!="")
        {
            txt = txt + vec[x].dia + ',' + vec[x].desde + ',' + vec[x].hasta + ';';
        }else
            {
                txt = txt + "EMPTY;";
            }
    }
    return txt;
}

function convertTimeToNum(time)
{
    var vec = time.split(":");
    return parseInt(vec[0]);    
}

function checkData(data)
{
    if(data.dia!="0" && data.desde!="0" && data.hasta!="0")
    {
        var Numdesde = convertTimeToNum(data.desde);
        var Numhasta = convertTimeToNum(data.hasta);
        if(Numdesde < Numhasta)
        {
            return true;           
        }
        else
            {
                alert(ADD_DAY_PROV_TIMEERROR_MSG); 
                return false;
            }
    }
    else
        {        
            // MENSAJE DE ERROR - VAR PASADA POR FORM.PHP
            alert(ADD_DAY_PROV_ERROR_MSG);
            return false;
        }
}


function processData()
{
    var data=new Datos();              
    data.dia = $('select[name="pago_prov_dia"]').val();               
    data.desde = $('select[name="pago_prov_desde"]').val(); 
    data.hasta = $('select[name="pago_prov_hasta"]').val();
    if(checkData(data))
    {    
        Nitem++;
        data.n = Nitem;
        vec[Nitem] = data;
        $('input[name="pago_proveedores_dias_horarios"]').val(VectoString());
        insertBlock(data);
        $('select[name="pago_prov_dia"]').html(days_list);
        $('select[name="pago_prov_desde"]').html(time_list);
        $('select[name="pago_prov_hasta"]').html(time_list);        
        $('select[name="pago_prov_dia"]').trigger("liszt:updated");
        $('select[name="pago_prov_desde"]').trigger("liszt:updated");
        $('select[name="pago_prov_hasta"]').trigger("liszt:updated");        
    }
}

function insertBlock(data)
{
    var htmlblock = '<div name="daytimeItem'+ data.n +'" id="itemBlock" class="daytime_block">' + diaSemana(data.dia) + ' | ' + data.desde + ' - ' + data.hasta + '<span><a name="btn_del" id="'+ data.n +'" class="htmltag delTag" href="'+ data.n +'">x</a></span></div>';   
    //$('input[name="pago_proveedores_dias_horarios"]').after(htmlblock);
    $("#itemBox").append(htmlblock);
}

function deleteItem(index)
{
    vec[index] = "";
    var name = "daytimeItem" + index;
    $('div[name=' + name + ']').slideUp(500,function(){ 
        $('div[name=' + name + ']').remove();
    });
    $('input[name="pago_proveedores_dias_horarios"]').val(VectoString());    
}

/**
 * Inicializa valores de dias-horarios de pago_provs
 */
function init_hidden_dias_horarios()
{
        var input = $('input[name="pago_proveedores_dias_horarios"]').val();
        if(input!="" && input!=0)
        {
            var vecDiasHorarios = $('input[name="pago_proveedores_dias_horarios"]').val().split(";");
            var num = -1;
            for (var i in vecDiasHorarios)
            {
                if(vecDiasHorarios[i]!="" && vecDiasHorarios[i]!="EMPTY") // sin ';' xq el simbolo es eliminado por split()
                {
                    var item = new Datos();
                    var reg = new Array();                    
                    num++;
                    reg = vecDiasHorarios[i].split(",");
                    item.dia = reg[0];
                    item.desde = reg[1];
                    item.hasta = reg[2];
                    item.n = num;                  
                    vec[num] = item;                    
                    insertBlock(item);
                }
            }
            Nitem = num;
        }        
}



