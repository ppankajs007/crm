<?php 

if ($data) { ?>
  
<tr>
  <td width="15%">
    <b>
      <?php if( $data['child'] ){ echo '* '; }elseif ( $data['subchild'] ) {
              echo '* * '; } echo $data['item_code'];   ?>
    </b>
  </td>
  <td width="20%"><b><?= $data['style_name']; ?></b></td>
  <td width="40%">
          <b><?= $data['main_description']; ?></b>
          <br><i><small><?php echo $data['custom_description']; ?></small><i>
  </td>
  <td width="5%"><b><?= $data['qty']; ?></b></td>
  <td><b>$<?= ($data['cust_price'])? decimalValue($data['cust_price']):'0.00'; ?></b></td>
  <td width="10%" class="text-right"><b>$<?= decimalValue($data['totalprice']); ?></b></td>
</tr>

<?php } ?>