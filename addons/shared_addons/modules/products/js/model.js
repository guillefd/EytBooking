// MODEL JS
// controller: accounts
// 
var vec=new Array();
var Nitem = -1;

function Datos()
{
    this.service = "";
    this.account = "";
    this.n = "";
}

function VectoString()
{
    var txt="";
    for (var x in vec)
    {
        if(vec[x]!="")
        {
            txt = txt + vec[x].service + ',' + vec[x].account + ';';
        }else
            {
                txt = txt + "EMPTY;";
            }
    }
    return txt;
}

function checkData(data)
{
    if(data.service=="" && data.account=="" || data.service=="" || data.account=="")
    {
        // VAR con texto error, pasada desde form.php
        alert(ADD_SOCIAL_ACCOUNT_ERROR_MSG); 
        return false;
    }else
        {
            return true;
        }
}

function processData()
{
    var data=new Datos();              
    data.service = $('select[name="dd_social"]').val();               
    data.account = $('input[name="user_account"]').val(); 
    if(checkData(data))
    {    
        Nitem++;
        data.n = Nitem;
        vec[Nitem] = data;
        $('input[name="chatSocial_accounts"]').val(VectoString());
        insertBlock(data);
        $('select[name="dd_social"]').html(social_list);
        $('input[name="user_account"]').val("");     
        $('select[name="dd_social"]').trigger("liszt:updated");
    }    
}

function insertBlock(data)
{
    var htmlblock = '<div name="socialItem'+ data.n +'" id="itemBlock" class="itemBlock">' + data.service + ': ' + data.account + '<span><a name="btn_del" id="'+ data.n +'" class="htmltag delTag" href="'+ data.n +'">x</a></span></div>';   
    $("#itemBox").append(htmlblock);
}

function deleteItem(index)
{
    vec[index] = "";
    var name = "socialItem" + index;
    $('div[name=' + name + ']').slideUp(500,function(){ 
        $('div[name=' + name + ']').remove();
    });
    $('input[name="chatSocial_accounts"]').val(VectoString());    
}

/**
 *  Inicializa valores de dias-horarios de pago_provs
 */
function init_hidden_dias_horarios()
{
        var input = $('input[name="chatSocial_accounts"]').val();
        if(input!="" && input!=0)
        {
            var vecSocial = $('input[name="chatSocial_accounts"]').val().split(";");
            var num = -1;
            for (var i in vecSocial)
            {
                if(vecSocial[i]!="" && vecSocial[i]!="EMPTY") // sin ';' xq es eliminado por split()
                {
                    var item = new Datos();
                    var reg = new Array();                    
                    num++;
                    reg = vecSocial[i].split(",");
                    item.service = reg[0];
                    item.account = reg[1];
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