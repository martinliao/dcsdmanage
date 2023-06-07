<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">K.切換志工帳號</h3>
            </div>
            <div class="box-body">  

                <table class="table table-bordered">
                    <tr>
                        <th>編號</th>
                        <th>志工名稱</th>
                        <th>志工資訊</th>
                        <th>切換</th>
                    </tr>
                    <?php foreach( $userList as $user ) : ?>
                        <tr>
                            <td>
                                <?php echo $user->id ?>
                            </td>
                            <td>
                                <?php echo $user->name ?>
                            </td>
                            <td>
                                <?php echo $user->idNo ?>
                                <br>
                                <?php echo $user->email ?>
                                <br>
                                <?php echo $user->address ?>
                            </td>
                            <td>
                                <a href="<?php echo $change_url ?><?php echo $_SESSION['userID'] ?>/<?php echo $user->id ?>">
                                    切換
                                </a>
                            </td>
                        </tr>
                    <?php endforeach ; ?>
                </table>

        </div>
    </div>
</div>