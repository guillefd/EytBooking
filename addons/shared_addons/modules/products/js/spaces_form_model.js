

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
                calculateSquare();
            }
    }


