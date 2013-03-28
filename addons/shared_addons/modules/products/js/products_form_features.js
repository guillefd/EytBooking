//selector de categoria
//autocarga de caracteristicas defecto
//adicion de features en listado

// global VAR
var vecF = new Object();
var vecFid;
var vec_prodF = new Array();
var Nitem = -1;

// FUNCTIONS ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

function Fdatos()
{
    this.default_f_id = "";
    this.name = "";
    this.description = "";
    this.usageunit = "";
    this.value = "";
    this.vecFid = "";
    this.n = "";
}

function reset_Fbox_state()
{
    $('input:text[name="usageunit"]').val('');
    $('#f_id').val('');
    $('#f_qty').val('');
    $('#f_description').val('');
    $('#f_add').attr('class','btn gray');
    vecFid = "";
    //reset dd features
    var options = $('select[name="dd_features"]').html();
    $('select[name="dd_features"]').html(options);
    $('select[name="dd_features"]').trigger("liszt:updated");  
}

function reset_itemBox()
{
    $("#f_itemBox").html("");
    vecF = {};
    vec_prodF = [];
    $('input[name="features"]').val("");
}

function load_values_from_Fvec(id)
{
    
    $('input:text[name="usageunit"]').val(vecF.items[id].usageunit);
    $('input[name="f_id"]').val(vecF.items[id].id);       
    $('#f_qty').val(vecF.items[id].value);          
    $('#f_description').val(vecF.items[id].description);
    $('#f_add').attr('class','btn green');  
}

// Process

function checkData(data)
{
    if( data.default_f_id == "" || data.value == "" || data.description == "" )
    {
        alert(MSG_ADD_ITEM_ERROR);
        return false;
    }else
        {
            return true;
        }
}

function insertBlock(data)
{
    var htmlblock = '<tr name="fItem'+ data.n +'" id="f_itemBlock" class="f_itemBlock">';
        htmlblock+= '<td>' + data.name + '</td><td>' + data.usageunit + '</td><td>' + data.value + '</td><td>' + data.description + '</td>';
        htmlblock+= '<td><span><a name="btn_del" id="'+ data.n +'" class="btn red" href="'+ data.n +'">' + LABEL_DELETE + '</a>';
        htmlblock+= '</tr>';   
    $("#f_itemBox").append(htmlblock);
}

function deleteFitem(index)
{
    vec_prodF[index] = "";
    var name = "fItem" + index;
    $('div[name=' + name + ']').slideUp(500,function(){ 
        $('div[name=' + name + ']').remove();
    });
    copy_to_features_input();  
}

function copy_to_features_input()
{
    //copy vec_prodF to input #features, in JSON format
    $('input[name="features"]').val(JSON.stringify(vec_prodF));    
}

function F_processData()
{
    var fdata=new Fdatos();
    fdata.default_f_id = $('input[name="f_id"]').val();
    fdata.name = vecF.items[vecFid].name;
    fdata.description = $('#f_description').val();
    fdata.value = $('#f_qty').val();
    fdata.usageunit = $('#usageunit').val();
    fdata.vecFid = vecFid;
    if(checkData(fdata))
    {
        Nitem++;
        fdata.n = Nitem;        
        vec_prodF[Nitem] = fdata;
        insertBlock(fdata);
        copy_to_features_input();
        reset_Fbox_state();
    }
}

function request_features()
{
    //img loader
    $('select[name="category_id"]').after(img_loader_2);                        
        var form_data = {
            cat_id : $('select[name="category_id"]').val()                    
        };
        $.ajax({
                type: "POST",
                url: SITE_URL + 'admin/products/get_features_ajax',
                data: form_data,
                dataType: 'json',
                success: function(result){
                    // quita el GIF
                    $('#loader').remove();
                if(result.status == 'OK') 
                {
                    var options;
                    vecF = result;
                    // valor vacio a proposito - para js-chosen
                    if(result.count < 1)
                    {
                        options = '<option>' + MSG_QUERY_EMPTY + '</option>';
                    }
                    if(result.count > 0)
                    {
                        options = '<option>' + MSG_SELECT + '</option>';
                        for (var i = 0; i < vecF.items.length; i++) 
                        {
                            options += '<option value="' + i + '">' + vecF.items[i].name + '</option>';
                        }
                    }
                } 
                if(result.status != 'OK') 
                {
                    options = '<option>' + MSG_QUERY_FEATURES_FAIL + '</option>'; 
                }
                //copy html to selector
                $('select[name="dd_features"]').html(options);
                //trigger que dispara la actualizacion del dropdown CHOSEN
                $('select[name="dd_features"]').trigger("liszt:updated");                 
            },
            error: function()
            {
                $('#loader').remove();   
            }            
    });     
}

// END FUNCTIONS ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

$(document).ready(function(){
        
   //Input Mask
   $('#f_qty').mask('000.0', {reverse: true});

   //watcher default feature dropdown
   $('select[name="dd_features"]').change(function() { 
       vecFid = $('select[name="dd_features"]').val();
       load_values_from_Fvec(vecFid);
   }); 
   
   //Add feature button
    $("#f_add").click(function() {
        $("#f_add").removeAttr('href');      
        if(vecFid>=0){ F_processData() };           
    }); 

    //watcher btn ELIMINAR item de lista de features
    $(document).on('click', 'a[name="btn_del"]', function(){ //do stuff here })
        $(this).removeAttr('href');
        var id = $(this).attr("id");
        deleteFitem(id);
    });    
   
   //watcher category dropdown
   $('select[name="category_id"]').change(function() {
       
       //resets
       reset_Fbox_state();
       //check if features are already selected
       if(vec_prodF.length > 0)
       {
           //confirm box
           var r = confirm(MSG_ALERT_CATEGORY_CHANGE);
           if (r==true)
           {
                reset_itemBox();
                request_features();
              
           }        
       }
       //check if features have not been selected yet
       if(vec_prodF.length == 0)
        {
            request_features();           
        }
   });  
      
   
});