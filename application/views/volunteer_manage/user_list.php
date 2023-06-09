<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">O.志工通訊錄</h3>
            </div>
            <div class="box-body">

                <table class="table table-bordered" id='user_list'>
                    <thead>
                        <tr>
                            <th>編號</th>
                            <th>志工名稱</th>
                            <th>志工資訊</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($userList as $user) : ?>
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
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(function() {
        //debugger;
        $('#user_list').DataTable({
            info: false,
            paging: false,
            searching: true,
            oLanguage:  {
              "sProcessing": "處理中...",
              "sInfoEmpty": "無任何資料",
              "sSearch": "搜尋",
          },
        });
        $('.dataTables_filter').addClass('pull-left');
    });
</script>