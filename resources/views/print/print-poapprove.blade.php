<div id="PODetail">

   <table width="100%" style="table table-bordered" border=1>
	   <tr>

	   <td width = "100%" height="51"><b><font = size ="6"> PT.JATIM PROPERTINDO JAYA</font></b>
		</td>
     </tr>
	   <tr>
	    <td width = "100%"><b><font = size ="4"><div align = "center">Purchase Order</div></font></b>
		</td>
     </tr>
	   <tr>
	    <td width = "100%"><b><font = size ="4"><div align = "center">
			<?php
			if($status==3){
				echo "REJECTED";
				//echo $status;
			}
			elseif($status==4){
				echo "CANCELLED";
				//echo $status;
			}else{
				echo $no_po;

			}?></div></font></b>
		</td>
     </tr>
  </table>
    <table width="100%" style="table-layout:fixed; font-size: 9pt;">
		<tr>
            <td width="24%"><b>Supplier</b></td>
            <td width="2%">:</td>
            <td width="24%"><?php echo $row->general_vendor_name; ?></td>
            <td width="24%"><b>Stockpile</b></td>
            <td width="2%">:</td>
            <td width="24%"><?php echo $row->stockpile_name; ?></td>
        </tr>
        <tr>
            <td width="24%"><b>Address</b></td>
            <td width="2%">:</td>
            <td width="24%" rowspan="3"><?php echo $row->general_vendor_address; ?></td>
            <td width="24%"><b>No.Penawaran</b></td>
            <td width="2%">:</td>
            <td width="24%"><?php echo $row->no_penawaran; ?></td>
        </tr>
        <tr>
            <td width="24%">&nbsp;</td>
            <td width="2%">&nbsp;</td>
            <td width="24%"><b>Tanggal</b></td>
            <td width="2%">:</td>
            <td width="24%"><?php echo $row->tanggal; ?></td>
        </tr>
		 <tr>
            <td width="24%">&nbsp;</td>
            <td width="2%">&nbsp;</td>
            <td width="24%">&nbsp;</td>
            <td width="2%">:</td>
            <td width="24%">&nbsp;</td>
        </tr>
		 <tr>
            <td width="24%"><b>Phone</b></td>
            <td width="2%">:</td>
            <td width="24%">&nbsp;</td>
            <td width="24%">&nbsp;</td>
            <td width="2%">&nbsp;</td>
            <td width="24%">&nbsp;</td>
        </tr>
		<tr>
            <td width="24%"><b>Fax</b></td>
            <td width="2%">:</td>
            <td width="24%">&nbsp;</td>
            <td width="24%">&nbsp;</td>
            <td width="2%">&nbsp;</td>
            <td width="24%">&nbsp;</td>
        </tr>


    </table>

    <!--<br/>-->
    <table width="100%" class="table table-bordered table-striped" style="font-size: 9pt;">
        <thead>
            <tr>
                <th align="left">Remarks</th>
          </tr>
        </thead>
        <tbody>
            <tr>
                <td <?php if($row->memo == '') echo 'style="height: 40px;"'; ?>><?php echo $row->memo; ?></td>
            </tr>
        </tbody>
    </table>
    <!--<br/>-->
    <?php
	$sql = "select qty, harga, keterangan, amount, i.item_name, pd.ppn,
			(case when pd.pphstatus = 1 then pd.pph else 0 end) as pph,
    		(pd.amount+pd.ppn-(case when pd.pphstatus = 1 then pd.pph else 0 end)) as grandtotal
			from po_detail pd
			left join master_item i on i.idmaster_item = pd.item_id
			WHERE no_po = '{$no_po}' ORDER BY idpo_detail ASC";
$result = $myDatabase->query($sql, MYSQLI_STORE_RESULT);



	?>
    <table width="100%" class="table table-bordered table-striped" style="font-size: 9pt;">
        <thead>
            <tr>
                <th>Qty</th>
                <th>Harga</th>
                <th>Item Description</th>
                <th>DPP</th>
				<th>PPN</th>
				<th>PPH</th>
				<th>Total</th>

            </tr>
        </thead>
        <tbody>
         <tr>
        <?php
		if($result !== false && $result->num_rows > 0) {
		 while($row = $result->fetch_object()) {

		$amount = $row->amount;
		$totalPrice = $totalPrice + $amount;
		$tpph = $row->pph;
		$tppn = $row->ppn;
		$tgtotal = $row->grandtotal;
		$totalpph = $totalpph + $tpph;
		$totalppn = $totalppn + $tppn;
		$totalall = $totalall + $tgtotal;


	 ?>


                <td><?php echo number_format($row->qty, 2, ".", ",");?></td>
                <td><?php echo number_format($row->harga, 2, ".", ",");?></td>
                <td><?php echo $row->item_name;?></td>
                <td style="text-align: right;"><?php echo number_format($row->amount, 2, ".", ",");?></td>
                <td style="text-align: right;"><?php echo number_format($row->ppn, 2, ".", ",");?></td>
			 	<td style="text-align: right;"><?php echo number_format($row->pph, 2, ".", ",");?></td>
			 	<td style="text-align: right;"><?php echo number_format($row->grandtotal, 2, ".", ",");?></td>

          </tr>
          <?php
		}
}
?>
        </tbody>
        <tfoot>

			<tr>
        <td colspan="3" style="text-align: right;">Total</td>
        <td colspan="1" style="text-align: right;"><?php echo number_format($totalPrice, 2, ".", ",");?></td>
       <td colspan="1" style="text-align: right;"><?php echo number_format($totalppn, 2, ".", ",");?></td>
		<td colspan="1" style="text-align: right;"><?php echo number_format($totalpph, 2, ".", ",");?></td>
		<td colspan="1" style="text-align: right;"><?php echo number_format($totalall, 2, ".", ",");?></td>
        </tr>

			<tr>


        </tr>
        </tfoot>
    </table>
	<table width="100%" class="table table-bordered table-striped" style="font-size: 9pt;">
        <thead>
            <tr>
                <th align="left">ToC</th>
          </tr>
        </thead>
        <tbody>
            <tr>
              <td <?php if($toc == '') echo 'style="height: 40px;"'; ?>><?php echo $toc; ?></td>
            </tr>
        </tbody>
    </table>
    <table width="100%">
      <tbody>
        <tr>
          <td width="58%">
		  <table width="100%" border="1">
            <tbody>
              <tr>
                <td width="17%">TT to</td>
                <td width="83%">:<?php echo $general_vendor_name ?></td>
              </tr>
              <tr>
                <td>Bank</td>
                <td>:<?php echo $bank_name ?></td>
              </tr>
              <tr>
                <td>Cabang</td>
                <td>:<?php echo $branch ?></td>
              </tr>
              <tr>
                <td>No Rek</td>
                <td>:<?php echo $account_no ?></td>
              </tr>
              <tr>
                <td>Swift Code</td>
                <td>:<?php echo $swift_code ?></td>
              </tr>
            </tbody>
          </table></td>
          <td width="42%">
		  <table width="100%" border="1">
            <tbody>
              <tr>
                <td>Prepare by,</td>
                <td>Check by,</td>
                <td>Approval by,</td>
              </tr>
              <tr>
                <td height="78">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td height="23"><?php echo $prepareby ?></td>
                <td><?php echo $checkby ?></td>
                <td></td>
              </tr>
            </tbody>
          </table></td>

        </tr>
      </tbody>
  </table>
</div>

<hr>

<div class="row-fluid">
    <div class="span12 lightblue">
        <button class="btn btn-primary" id="printPODetail">Print</button>
		 <button class="btn" type="button" onclick="back()">Back</button>
        <?php if($_SESSION['userId'] == 19) {
?>
<button class="btn btn-warning" id="reject">Reject</button>
<button class="btn btn-warning" id="cancel">Cancel</button>
<?php
}
?>
  </div>
</div>

<?php
    // </editor-fold>
}
?>
