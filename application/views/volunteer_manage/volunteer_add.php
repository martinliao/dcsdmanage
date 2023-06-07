<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">新增志工 - <?=htmlspecialchars($year, ENT_HTML5|ENT_QUOTES).'年 '?><?=htmlspecialchars($class_name, ENT_HTML5|ENT_QUOTES)?><?=' 第'.htmlspecialchars($term, ENT_HTML5|ENT_QUOTES).'期'?></h3>
            </div>
            <div class="box-body">  

                <table class="table table-bordered">
                    <tr>
                        <th>編號</th>
                        <th>志工名稱</th>
                        <th>志工資訊</th>
                        <th>操作</th>
                    </tr>
                    <?php foreach( $userList as $user ) : ?>
                        <tr>
                            <td>
                                <?php echo htmlspecialchars($user->id, ENT_HTML5|ENT_QUOTES) ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($user->name, ENT_HTML5|ENT_QUOTES) ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($user->idNo, ENT_HTML5|ENT_QUOTES) ?>
                                <br>
                                <?php echo htmlspecialchars($user->email, ENT_HTML5|ENT_QUOTES) ?>
                                <br>
                                <?php echo htmlspecialchars($user->address, ENT_HTML5|ENT_QUOTES) ?>
                            </td>
                            <td>
                                <button type='button' class='btn btn-success btn-flat' style='margin-left: 5px' onclick='signFun(<?=htmlspecialchars($user->id, ENT_HTML5|ENT_QUOTES)?>)'>報名</button>
                            </td>
                        </tr>
                    <?php endforeach ; ?>
                </table>
                <form id="send" action="<?=htmlspecialchars($save_url, ENT_HTML5|ENT_QUOTES)?>" method="post">
                    <input type="hidden" name="id" value="<?=htmlspecialchars($id, ENT_HTML5|ENT_QUOTES)?>">
                    <input type="hidden" name="sign_date" value="<?=htmlspecialchars($sign_date, ENT_HTML5|ENT_QUOTES)?>">
                    <input type="hidden" name="sign_time" value="<?=htmlspecialchars($sign_time, ENT_HTML5|ENT_QUOTES)?>">
                    <input type="hidden" name="uid" id="uid" value="">
                </form>
        </div>
    </div>
</div>

<script>
    function signFun(id){
        var obj = document.getElementById('send');
        document.getElementById('uid').value = id;
        obj.submit();
    }
</script>