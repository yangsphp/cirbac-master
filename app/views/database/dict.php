 <form action="#" method="post" onsubmit="return false;" id="add_database_form">
	<div class="form-group">
	  <table class="table table-bordered">
            <tbody>
            <tr>
                <th>字段名</th>
                <th>字段类型</th>
                <th>注释</th>
            </tr>
            <?php foreach ($dict as $k => $v){?>
            <tr>
                <td><?php echo $v['Field']?></td>
                <td><?php echo $v['Type']?></td>
                <td>
                    <input class="" type="text" name="Field[<?php echo $v['Field']?>]" value="<?php echo $v['comment']?>">
                    <input class="" type="hidden" name="Type[<?php echo $v['Field']?>]" value="<?php echo $v['Type']?>">
                </td>
            </tr>
            <?php }?>
            </tbody>
        </table>
	</div>
	<input type="hidden" name="table" value="<?php echo $table?>">
</form>
<script>

</script>