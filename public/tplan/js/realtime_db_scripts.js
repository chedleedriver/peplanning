/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function lookUp(what,whatWith,where){
     jQuery.ajax({
                        type: "GET",
                        url: "/tplan/code/realtime_db_processing.php",
                        data: {
                            toDo: 'look',
                            doWhat: what,
                            withWhat: whatWith
                        },
                        dataType: "json",
                        beforeSend: function () {

                        },
                        success: function (data) {
                            if (data==1) {
                                $('#'+where).focus();
                                alert (what+" already taken");
                            }
                        },
                        beforeSend: null,
                        complete: function () {
                            
                        }
                    })
}

