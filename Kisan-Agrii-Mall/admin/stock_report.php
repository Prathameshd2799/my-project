<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h3 class="card-title">Stock Report</h3>
        <div class="card-tools align-middle">
            <button class="btn btn-success btn-sm py-1 rounded-0" type="button" id="print">Print</button>
        </div>
    </div>
    <div class="card-body">
        <div id="outprint">
        <table class="table table-hover table-striped table-bordered">
            <!-- <colgroup>
                <col width="5%">
                <col width="15%">
                <col width="25%">
                <col width="25%">
                <col width="10%">
                <col width="10%">
                <col width="10%">
            </colgroup> -->
            <thead>
            <tr>
                  
                    <th class="text-center p-0">Date Added</th>
                    <th class="text-center p-0">Product</th>
                    <th class="text-center p-0">Quantity</th>
                    
                </tr>
            </thead>
            <tbody>
            <?php 
                $sql = "SELECT i.*,p.name FROM `inventory_list` i inner join product_list p on i.product_id = p.product_id where i.type = 1 order by strftime('%s',i.date_created) desc";
                $qry = $conn->query($sql);
                $i = 1;
                    while($row = $qry->fetchArray()):
                        $thumbnail = '../uploads/thumbnails/'.$row['product_id'].'.png';
                ?>
                <tr class="text-center p-0"><?php echo $i++; ?></td>
                    <td class="py-0 px-1"><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
                    <td class="py-0 px-1">
                        <div class="w-100 d-flex align-items-center">
                            <div class="col-auto">
                                <img src="<?php echo $thumbnail ?>" alt="img" class="thumbnail-img border rounded broder-light">
                            </div>
                            <div class="col-auto flex-grow-1">
                                <div class="lh-1">
                                    <span class="text-muted">Name: </span><span><?php echo $row['name'] ?></span>
                                </div>
                                <td class="py-0 px-1 text-end"><?php echo number_format($row['quantity']) ?></td>

                            </div>
                        </div>
                    </tr>
                <?php endwhile; ?>
               
            </tbody>
        </table>
        </div>
    </div>
</div>
<script>
    $(function(){
       $('#print').click(function(){
           var _h = $('head').clone()
           var data = $('#outprint').clone()
           var el = $('<div>')
           _h.find('title').text('Sales Report Print Preview')
           el.append(_h)
           el.append('<h3 class="text-center">Sales Report</h3><hr/>')
           el.append(data)
           var nw = window.open("","","height=900,width=1200,left=70")
           nw.document.write(el.html())
           nw.document.close()
           setTimeout(() => {
               nw.print()
               setTimeout(() => {
                   nw.close()
               }, 200);
           }, 500);
       }) 
    })
</script>