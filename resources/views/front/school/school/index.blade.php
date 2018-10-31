@extends('front.school.main')
@section('title', '教育机构查询')
@section('body_content')
    <div class="main">
        <form action="" onsubmit="return false;">
            <label for="" class="serchBtn">
                <input type="text" placeholder="搜索学校" name='keyword' id="schoolName">
                <i class="submitBtn"></i>
            </label>
        </form>
        <div class="serResult" style="display: none;">
            <div class="result">搜索结果：</div>
            <div class="schooleList">
            </div>
        </div>
        <script>
            function schoolList(data){
                $(".schooleList").show()
                if(data.length>0){
                    var html = '';
                    $.each(data, function(index, item){
                        html+='<div class="result-item">'+
                            '<h4>'+item.name+'</h4>'+
                            '<p class="item-address">地址：'+item.address+'</p>'+
                            '<p class="item-property">性质：'+item.property+'</p>'+
                            '<p class="item-phone">联系电话: '+item.telent+'</p>'+
                            '</div>'
                    })
                    $(".schooleList").html(html)
                }
            }
            $(function(){
                $('.submitBtn').click(function(){
                    var schoolName = $("#schoolName").val();
                    $(".serResult").show()
                    $.ajax({
                        url:"{{ $check_url }}",
                        type:"post",
                        data:{keyword: schoolName},
                        success:function(data){
                            var data = JSON.parse(data);
                            schoolList(data.result);
                        },
                        error:function(e){
                            alert("错误！！");
                        }
                    })
                });
            })
        </script>
    </div>
@endsection