<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h3 class="card-title">Product Report</h3>
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
               <th class="text-center p-0">#</th>
                    <th class="text-center p-0">Date Updated</th>
                    <th class="text-center p-0">Info</th>
                    <th class="text-center p-0">Description</th>
                    <th class="text-center p-0">Stock Available</th>
                    <th class="text-center p-0">Status</th>
                    
                </tr>
            </tr>
            </thead>
            <tbody>
            <?php 
                $sql = "SELECT p.*,c.name as category FROM `product_list` p inner join category_list c on p.category_id = c.category_id order by p.`name` asc";
                $qry = $conn->query($sql);
                $i = 1;
                    while($row = $qry->fetchArray()):
                        $in = $conn->query("SELECT SUM(quantity) as `in` from inventory_list where product_id = '{$row['product_id']}' and `type` = 1")->fetchArray()['in'];
                        $out = $conn->query("SELECT SUM(quantity) as `out` from inventory_list where product_id = '{$row['product_id']}' and `type` = 2")->fetchArray()['out'];
                        $row['available'] = $in - $out;
                        $thumbnail = '../uploads/thumbnails/'.$row['product_id'].'.png';
                ?>
                     <tr>
                    <td class="text-center p-0"><?php echo $i++; ?></td>
                    <td class="py-0 px-1"><?php echo date("Y-m-d H:i",strtotime($row['date_updated'])) ?></td>
                    <td class="py-0 px-1">
                        <div class="w-100 d-flex align-items-center">
                            <div class="col-auto">
                                <img src="<?php echo $thumbnail ?>" alt="img" class="thumbnail-img border rounded broder-light">
                            </div>
                            <div class="col-auto flex-grow-1">
                                <div class="lh-1 w-100 text-break">
                                    <span class=""><?php echo $row['name'] ?></span><br>
                                    <span class=""><?php echo $row['category'] ?></span>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="py-0 px-1"  title="<?php echo $row['description'] ?>"><p class="m-0 truncate-1"><small><i><?php echo $row['description'] ?></i></small></p></td>
                    <td class="py-0 px-1 text-end"><?php echo number_format($row['available']) ?></td>
                    <td class="py-0 px-1 text-center">
                    <?php if($row['status'] == 1): ?>
                        <span class="badge bg-success"><small>Active</small></span>
                    <?php else: ?>
                        <span class="badge bg-danger"><small>Inactive</small></span>
                    <?php endif; ?>
                    </td>
                    <th class="text-center py-0 px-1">
                       
                    </th>
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