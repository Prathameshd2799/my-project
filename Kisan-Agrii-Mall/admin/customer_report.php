<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h3 class="card-title">Customer Report</h3>
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
            <tr>
                    <th class="text-center p-0">#</th>
                    <th class="text-center p-0">Name</th>
                    <th class="text-center p-0">Info</th>
                    <th class="text-center p-0">Username</th>
                    <th class="text-center p-0">Status</th>
                </tr>
            </tr>
            </thead>
            <tbody>
            <?php 
                $sql = "SELECT * FROM `customer_list` order by `fullname` asc";
                $qry = $conn->query($sql);
                $i = 1;
                    while($row = $qry->fetchArray()):
                ?>
                <tr>
                    <td class="text-center p-0"><?php echo $i++; ?></td>
                    <td class="py-0 px-1"><?php echo $row['fullname'] ?></td>
                    <td class="py-0 px-1">
                        <div class="fs-6">Email: <?php echo $row['email'] ?></div>
                        <div class="fs-6">Contact: <?php echo $row['contact'] ?></div>
                        <div class="fs-6 truncate-1" title="<?php echo $row['address'] ?>">Address: <?php echo $row['address'] ?></div>
                    </td>
                    <td class="py-0 px-1"><?php echo $row['username'] ?></td>
                    <td class="py-0 px-1 text-center">
                    <?php if($row['status'] == 1): ?>
                        <span class="badge bg-success"><small>Active</small></span>
                    <?php else: ?>
                        <span class="badge bg-danger"><small>Inactive</small></span>
                    <?php endif; ?>
                    </td>
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