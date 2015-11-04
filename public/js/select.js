/**
 * Created by CristianoGD on 11/10/2015.
 */
var pathname = window.location.pathname; // Returns path only
var url      = window.location.href+"/";
$(document).ready(function(){
    //alert("Ready"+$("#tipoUsuario").val());
    //alert("Ready"+url);
    $("#selectCountry").change(function(){
        //alert("change: "+$("#selectCountry").val());

        //console.log($("#selectCountry").val());
        $.ajax({
            type: "POST",
            src: "RelatorioController.php",
            data: {getSelect:$("#selectCountry").val()},
            dataType: "json",
            success: function(json){
                alert("success"+$("#selectCountry").val());
                var options = "";
                $.each(json, function(key, value){
                    options += '<option value="' + key + '">' + value + '</option>';
                });
                $("#selectCountry").html(options);
            }
        });
    });
});