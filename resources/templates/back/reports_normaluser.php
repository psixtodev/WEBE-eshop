<div class="row">

<h1 class="page-header">
   All Reports

</h1>

<h3 class="bg-warning"><?php display_message(); ?></h3>

<table class="table table-hover">


    <thead>

      <tr>
           <th>Id</th>
           <th>Product Id</th>
           <th>Order Id</th>
           <th>Price</th>
           <th>Product title</th>
           <th>Product Quantity</th>
      </tr>
    </thead>
    <tbody>

    <?php get_reports_normaluser($_SESSION['username'],$_SESSION['password']); ?>

    </tbody>
</table>

