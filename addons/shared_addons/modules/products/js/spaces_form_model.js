

function calculateSquare()
{
    var width = $("#width").val();
    var length = $("#length").val();
    var height = $("#height").val();
    if(width>0 && length>0){
        var square = width * length;
        $("#square_mt").val(square);
    }
}

function checkData(selector)
{        
        var value = $('input[name=' + selector.name + ']').val();
        if(isNaN(value))
        {
            alert(ADD_DIMENTION_VALUE_ERROR_MSG);             
            $('input[name=' + selector.name + ']').val("");
            $('input[name=' + selector.name + ']').focus();
        }
        else
        {
            if(selector.name!="square_mt")calculateSquare();
        }
    }

/// LAYOUTS CAPACITY

var vec=new Array();
var Nitem = -1;

function Datos()
{
    this.layout = "";
    this.capacity = "";
    this.id = "";
    this.n = "";
}

function VectoString()
{
    var txt="";
    for (var x in vec)
    {
        if(vec[x]!="")
        {
            txt = txt + vec[x].id + ',' + vec[x].capacity + ';';
        }else
            {
                txt = txt + "EMPTY;";
            }
    }
    return txt;
}

function checkInput(data)
{
    if(data.id=="" && data.capacity=="" || data.id=="" || data.capacity=="")
    {
        // VAR con texto error, pasada desde form.php
        alert(ADD_LAYOUT_ERROR_MSG); 
        return false;
    }else
        {
            if(isNaN(data.capacity))
            {
                alert(ISNAN_VALUE_ERROR_MSG);  
                return false;                
            }
            else
                {
                    return true;
                }
        }
}

function processData()
{
    var data=new Datos();              
    data.id = $('select[name="dd_layouts"]').val();
    data.layout = dd_layouts_array[data.id]                
    data.capacity = $('input[name="capacity"]').val(); 
    if(checkInput(data))
    {    
        Nitem++;
        data.n = Nitem;
        vec[Nitem] = data;
        $('input[name="layouts"]').val(VectoString());
        insertBlock(data);
        $('select[name="dd_layouts"]').html(layouts_list);
        $('input[name="capacity"]').val("");     
        $('select[name="dd_layouts"]').trigger("liszt:updated");
    }    
}

function insertBlock(data)
{
    //var htmlblock = '<div name="item'+ data.n +'" id="itemBlock" class="itemBlock">' + data.layout + ': ' + data.capacity + '<span><a name="btn_del" id="'+ data.n +'" class="htmltag delTag" href="'+ data.n +'">x</a></span></div>';   
    var htmlblock = '<tr name="item'+ data.n +'" id="itemBlock" class="trBlock"><td>' + data.layout + '</td><td>' + data.capacity + '</td><td><span><a name="btn_del" id="'+ data.n +'" class="htmltag delTag" href="'+ data.n +'">x</a></span></td></tr>';   
    $("#itemBox").append(htmlblock);
}

function deleteItem(index)
{
    vec[index] = "";
    var name = "item" + index;
    $('tr[name=' + name + ']').fadeOut(500,function(){ 
        $('tr[name=' + name + ']').remove();
    });
    $('input[name="layouts"]').val(VectoString());    
}

/**
 *  Inicializa valores de dias-horarios de pago_provs
 */
function init_hidden_layouts()
{
        var input = $('input[name="layouts"]').val();
        if(input!="" && input!=0)
        {
            var vecLayouts = $('input[name="layouts"]').val().split(";");
            var num = -1;
            for (var i in vecLayouts)
            {
                if(vecLayouts[i]!="" && vecLayouts[i]!="EMPTY") // sin ';' xq es eliminado por split()
                {
                    var item = new Datos();
                    var reg = new Array();                    
                    num++;
                    reg = vecLayouts[i].split(",");
                    item.id = reg[0];
                    item.capacity = reg[1];
                    item.layout = dd_layouts_array[item.id];
                    item.n = num;                  
                    vec[num] = item;                    
                    insertBlock(item);
                }
            }
            Nitem = num;
        }        
}


/**
 * Do ajax request for Index - table view
 * @param keyword_filter select object selector
 * @param account_filter select object selector
 * @param city_filter input object selector
 * @param link URL to send query, responds HTML
 * success updates #table with new values
 */
function doAjaxQuery(keyword_filter, account_filter, city_filter, link)
{

    var form_data = {
        f_account : account_filter.val(),  
        f_keywords: keyword_filter.val(),
        f_city: city_filter.val()
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

