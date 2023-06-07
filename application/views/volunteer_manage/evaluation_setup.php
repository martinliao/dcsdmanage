<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">設定自評可填寫時間</h3>
            </div>
            <div class="box-body">  

                <table class="table table-bordered" style="font-size:20px">
                    <tr>
                        <td style="width: 200px;">年度</td>
                        <td>
                            <select id="year" class="form-control" style="font-size:19px;height:40px">
                                <?php
                                    $current_year = date('Y')-1911;
                                    $target_year = $current_year + 1;
                                    for($i=$target_year;$i>=110;$i--){
                                        if($i == $current_year){
                                            echo '<option value="'.$i.'" selected>'.$i.'</option>';
                                        } else {
                                            echo '<option value="'.$i.'">'.$i.'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 200px;">上下半年</td>
                        <td>
                            <select id="helf" class="form-control" style="font-size:19px;height:40px">
                                <option value="1">上半年</option>
                                <option value="2">下半年</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 200px;">分類</td>
                        <td>
                            <select id="category" class="form-control" style="font-size:19px;height:40px">
                                <option value="1">班務</option>
                                <option value="2">警衛</option>
                                <option value="3">圖書</option>
                                <option value="4">客服</option>
                                <option value="7">行政</option>
                                <option value="8">會計</option>
                                <option value="9">人事</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 200px;">填寫_開始時間</td>
                        <td>
                            <input type="date" id="startTime" class="form-control" value="<?php echo date('Y-m-d') ?>" style="font-size:19px;height:40px">
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 200px;">填寫_結束時間</td>
                        <td>
                            <input type="date" id="endTime" class="form-control" value="<?php echo date('Y-m-d') ?>" style="font-size:19px;height:40px">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button id="ajax-add" class="btn btn-primary" style="float: right;font-size:20px">
                                新增
                            </button>
                        </td>
                    </tr>
                </table>

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$('#ajax-add').on('click', function(event) {
    event.preventDefault();
    /* Act on the event */
    var startTime = $('#startTime').val();
    var endTime = $('#endTime').val();

    // make
    var insertData = {
        year            : $('#year').val()                      ,
        helf            : $('#helf').val()                      ,
        category        : $('#category').val()                  ,
        startTime       :  startTime                            ,
        endTime         :  endTime                              ,
    } ;

    // ajax
    $.ajax({
        url: '../evaluation/ajax_insert_evaluation',
        type: 'POST',
        dataType: 'json',
        data: insertData,
    })
    .done(function(msg) {
        if (msg.code=='100') {
            alert('新增完成！');
            location.reload() ;
        } else {
            alert('新增失敗，請稍後再試！');
        }
    })
    .fail(function() {
        alert('新增失敗，請稍後再試！');
    })
    .always(function() {
        console.log("complete");
    });
});
</script>


<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">  

                <table class="table table-bordered" style="font-size:20px">
                    <tr>
                        <th>編號</th>
                        <th>年度</th>
                        <th>上下半年</th>
                        <th>分類</th>
                        <th>填寫_開始時間</th>
                        <th>填寫_結束時間</th>
                        <th>操作</th>
                    </tr>
                    <?php foreach( $set_list as $data ) : ?>
                        <tr>
                            <td>
                                <?php echo htmlspecialchars($data->id,ENT_HTML5|ENT_QUOTES)?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($data->year,ENT_HTML5|ENT_QUOTES) ?>
                            </td>
                            <td>
                                <?php echo ($data->helf=='1')?'上半年':'下半年'?>
                            </td>
                            <td>
                                <?php
                                    switch( $data->category ) {
                                        case '1': echo "班務" ; break ;
                                        case '2': echo "警衛" ; break ;
                                        case '3': echo "圖書" ; break ;
                                        case '4': echo "客服" ; break ;
                                        case '7': echo "行政" ; break ;
                                        case '8': echo "會計" ; break ;
                                        case '9': echo "人事" ; break ;
                                    } ;
                                ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($data->start_time,ENT_HTML5|ENT_QUOTES) ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($data->end_time,ENT_HTML5|ENT_QUOTES) ?>
                            </td>
                            <td>
                                <button class="btn btn-danger ajax-det" no="<?php echo $data->id ?>" style="font-size:20px">
                                    刪除
                                </button>
                            </td>
                        </tr>
                    <?php endforeach ; ?>
                </table>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$('.ajax-det').on('click', function(event) {
    event.preventDefault();
    /* Act on the event */
    var no = $(this).attr('no') ;
    // make
    var insertData = {
        id   :  no    ,
    } ;
    if ( confirm('確定刪除此限制？') ) {
        // ajax
        $.ajax({
            url: '../evaluation/ajax_delete_evaluation',
            type: 'POST',
            dataType: 'json',
            data: insertData,
        })
        .done(function(msg) {
            if (msg.code=='100') {
                alert('刪除完成！');
                location.reload() ;
            } else {
                alert('刪除失敗，請稍後再試！');
            }
        })
        .fail(function() {
            alert('刪除失敗，請稍後再試！');
        })
        .always(function() {
            console.log("complete");
        });
    }
});
</script>