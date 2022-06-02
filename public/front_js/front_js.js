$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $('.visit-exam-password').click(function(){
        localStorage.clear();
        var exam_id=$(this).attr('data-exam');
        var subject_id=$(this).attr('data-subject');
        var grade_id=$(this).attr('data-grade');

        Swal.fire({
            title: "Enter password",
            text:"",
            input:"text",
            // icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Confirm!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url:'check-password-exam',
                    type:'POST',
                    data:{
                        password:result.value,
                        exam_id:exam_id
                    },
                    success:function(resp){
                        if(resp['status']==true){
                            window.location.href="/exam/"+exam_id+'/subject/'+subject_id+'/grade/'+grade_id;
                        }else{
                            alert('WRONG PASSWORD');
                        }
                    },
                    error:function(err){
                        alert('ERROR');
                    }
                })

            }
        });
    });
    $('.visit-exam').click(function(){
        localStorage.clear();
    })
    $("#current_password").keyup(function () {
        var current_password = $(this).val();
        // alert(current_password);
        $.ajax({
            type: "POST",
            url: "/admin/check-update-pwd",
            data: {
                current_password: current_password,
            },
            success: function (resp) {
                // alert(resp);
                if (resp["status"] == false) {
                    $("#chkpwd").html(
                        "<font color=red>Current Password is incorrect</font>"
                    );
                } else {
                    $("#chkpwd").html(
                        "<font color=green>Current Password is correct</font>"
                    );
                }
            },
            error: function () {
                alert("error");
            },
        });
    });

    $('.visit-to-question').click(function(){
        var question_id=$(this).attr('question-id');
        // alert(question_id);
        $.ajax({
            url:'/visit-to-question',
            type: 'POST',
            data:{
                question_id:question_id
            },success:function(resp){
                if(resp['status']==true){
                }
            },error:function(err){
                alert('ERROR');
            }
        })
    });



});
var loadfile = function (event) {
    var output = document.getElementById("output");
    output.src = URL.createObjectURL(event.target.files[0]);
};
