<?php

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/admin.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <?= include 'layoutTopnav_nav.php'; ?>
    <div id="layoutSidenav">
        <?= include 'layoutSidenav_nav.php'; ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">Primary Card</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <div class="small text-white">test value 0</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body">Warning Card</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <div class="small text-white">test value 0</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body">Success Card</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <div class="small text-white">test value 0</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-danger text-white mb-4">
                                <div class="card-body">Danger Card</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <div class="small text-white">test value 0</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-area me-1"></i>
                                    Customer rate per day
                                </div>
                                <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar me-1"></i>
                                    Monthly income Bar chart
                                </div>
                                <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            DataTable Example
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Category</th>
                                        <th>Quantity</th>
                                        <th>Table Number</th>
                                        <th>Time</th>
                                        <th>Cost</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Latte</td>
                                        <td>Coffee</td>
                                        <td>2</td>
                                        <td>12</td>
                                        <td>09:15 AM</td>
                                        <td>RM9.00</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Almond Croissant</td>
                                        <td>Pastry</td>
                                        <td>1</td>
                                        <td>5</td>
                                        <td>09:18 AM</td>
                                        <td>RM5.50</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Cappuccino</td>
                                        <td>Coffee</td>
                                        <td>1</td>
                                        <td>23</td>
                                        <td>09:22 AM</td>
                                        <td>RM4.75</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Turkey Club Sandwich</td>
                                        <td>Food</td>
                                        <td>1</td>
                                        <td>41</td>
                                        <td>09:25 AM</td>
                                        <td>RM10.50</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Iced Tea</td>
                                        <td>Beverage</td>
                                        <td>2</td>
                                        <td>8</td>
                                        <td>09:26 AM</td>
                                        <td>RM7.00</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Espresso</td>
                                        <td>Coffee</td>
                                        <td>1</td>
                                        <td>67</td>
                                        <td>09:30 AM</td>
                                        <td>RM3.00</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Blueberry Muffin</td>
                                        <td>Pastry</td>
                                        <td>3</td>
                                        <td>15</td>
                                        <td>09:31 AM</td>
                                        <td>RM9.75</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Americano</td>
                                        <td>Coffee</td>
                                        <td>1</td>
                                        <td>99</td>
                                        <td>09:33 AM</td>
                                        <td>RM4.00</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Avocado Toast</td>
                                        <td>Food</td>
                                        <td>1</td>
                                        <td>2</td>
                                        <td>09:35 AM</td>
                                        <td>RM8.50</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Mocha</td>
                                        <td>Coffee</td>
                                        <td>1</td>
                                        <td>14</td>
                                        <td>09:40 AM</td>
                                        <td>RM5.50</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Orange Juice</td>
                                        <td>Beverage</td>
                                        <td>1</td>
                                        <td>31</td>
                                        <td>09:42 AM</td>
                                        <td>RM5.00</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Bagel with Cream Cheese</td>
                                        <td>Food</td>
                                        <td>2</td>
                                        <td>7</td>
                                        <td>09:45 AM</td>
                                        <td>RM12.00</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Flat White</td>
                                        <td>Coffee</td>
                                        <td>1</td>
                                        <td>50</td>
                                        <td>09:50 AM</td>
                                        <td>RM5.00</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Chocolate Chip Cookie</td>
                                        <td>Pastry</td>
                                        <td>4</td>
                                        <td>18</td>
                                        <td>09:51 AM</td>
                                        <td>RM12.00</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Iced Latte</td>
                                        <td>Coffee</td>
                                        <td>1</td>
                                        <td>29</td>
                                        <td>09:55 AM</td>
                                        <td>RM5.00</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Matcha Latte</td>
                                        <td>Beverage</td>
                                        <td>2</td>
                                        <td>33</td>
                                        <td>10:01 AM</td>
                                        <td>RM12.00</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Caesar Salad</td>
                                        <td>Food</td>
                                        <td>1</td>
                                        <td>11</td>
                                        <td>10:05 AM</td>
                                        <td>RM9.00</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Pain au Chocolat</td>
                                        <td>Pastry</td>
                                        <td>2</td>
                                        <td>9</td>
                                        <td>10:10 AM</td>
                                        <td>RM10.00</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Cold Brew</td>
                                        <td>Coffee</td>
                                        <td>1</td>
                                        <td>42</td>
                                        <td>10:12 AM</td>
                                        <td>RM6.00</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Hot Chocolate</td>
                                        <td>Beverage</td>
                                        <td>1</td>
                                        <td>81</td>
                                        <td>10:15 AM</td>
                                        <td>RM5.00</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Quiche Lorraine</td>
                                        <td>Food</td>
                                        <td>1</td>
                                        <td>27</td>
                                        <td>10:20 AM</td>
                                        <td>RM7.50</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Scone with Jam</td>
                                        <td>Pastry</td>
                                        <td>2</td>
                                        <td>1</td>
                                        <td>10:21 AM</td>
                                        <td>RM9.00</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Caramel Macchiato</td>
                                        <td>Coffee</td>
                                        <td>1</td>
                                        <td>16</td>
                                        <td>10:25 AM</td>
                                        <td>RM6.50</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Sparkling Water</td>
                                        <td>Beverage</td>
                                        <td>1</td>
                                        <td>53</td>
                                        <td>10:30 AM</td>
                                        <td>RM2.50</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Cheesecake Slice</td>
                                        <td>Pastry</td>
                                        <td>1</td>
                                        <td>22</td>
                                        <td>10:32 AM</td>
                                        <td>RM8.00</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Latte</td>
                                        <td>Coffee</td>
                                        <td>1</td>
                                        <td>19</td>
                                        <td>10:35 AM</td>
                                        <td>RM4.50</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Americano</td>
                                        <td>Coffee</td>
                                        <td>2</td>
                                        <td>3</td>
                                        <td>10:40 AM</td>
                                        <td>RM8.00</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Almond Croissant</td>
                                        <td>Pastry</td>
                                        <td>2</td>
                                        <td>30</td>
                                        <td>10:41 AM</td>
                                        <td>RM11.00</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Turkey Club Sandwich</td>
                                        <td>Food</td>
                                        <td>1</td>
                                        <td>60</td>
                                        <td>10:45 AM</td>
                                        <td>RM10.50</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Espresso</td>
                                        <td>Coffee</td>
                                        <td>2</td>
                                        <td>10</td>
                                        <td>10:47 AM</td>
                                        <td>RM6.00</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Iced Tea</td>
                                        <td>Beverage</td>
                                        <td>1</td>
                                        <td>4</td>
                                        <td>10:50 AM</td>
                                        <td>RM3.50</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Cappuccino</td>
                                        <td>Coffee</td>
                                        <td>1</td>
                                        <td>37</td>
                                        <td>10:52 AM</td>
                                        <td>RM4.75</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Blueberry Muffin</td>
                                        <td>Pastry</td>
                                        <td>1</td>
                                        <td>26</td>
                                        <td>10:55 AM</td>
                                        <td>RM3.25</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Avocado Toast</td>
                                        <td>Food</td>
                                        <td>2</td>
                                        <td>71</td>
                                        <td>11:00 AM</td>
                                        <td>RM17.00</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Mocha</td>
                                        <td>Coffee</td>
                                        <td>1</td>
                                        <td>55</td>
                                        <td>11:02 AM</td>
                                        <td>RM5.50</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Orange Juice</td>
                                        <td>Beverage</td>
                                        <td>3</td>
                                        <td>17</td>
                                        <td>11:05 AM</td>
                                        <td>RM15.00</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Bagel with Cream Cheese</td>
                                        <td>Food</td>
                                        <td>1</td>
                                        <td>49</td>
                                        <td>11:10 AM</td>
                                        <td>RM6.00</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Flat White</td>
                                        <td>Coffee</td>
                                        <td>1</td>
                                        <td>88</td>
                                        <td>11:11 AM</td>
                                        <td>RM5.00</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Chocolate Chip Cookie</td>
                                        <td>Pastry</td>
                                        <td>2</td>
                                        <td>63</td>
                                        <td>11:15 AM</td>
                                        <td>RM6.00</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Iced Latte</td>
                                        <td>Coffee</td>
                                        <td>1</td>
                                        <td>13</td>
                                        <td>11:20 AM</td>
                                        <td>RM5.00</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Matcha Latte</td>
                                        <td>Beverage</td>
                                        <td>1</td>
                                        <td>34</td>
                                        <td>11:22 AM</td>
                                        <td>RM6.00</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Caesar Salad</td>
                                        <td>Food</td>
                                        <td>2</td>
                                        <td>51</td>
                                        <td>11:30 AM</td>
                                        <td>RM18.00</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Pain au Chocolat</td>
                                        <td>Pastry</td>
                                        <td>1</td>
                                        <td>44</td>
                                        <td>11:31 AM</td>
                                        <td>RM5.00</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Cold Brew</td>
                                        <td>Coffee</td>
                                        <td>1</td>
                                        <td>32</td>
                                        <td>11:35 AM</td>
                                        <td>RM6.00</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Hot Chocolate</td>
                                        <td>Beverage</td>
                                        <td>2</td>
                                        <td>21</td>
                                        <td>11:40 AM</td>
                                        <td>RM10.00</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Quiche Lorraine</td>
                                        <td>Food</td>
                                        <td>1</td>
                                        <td>6</td>
                                        <td>11:42 AM</td>
                                        <td>RM7.50</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Scone with Jam</td>
                                        <td>Pastry</td>
                                        <td>1</td>
                                        <td>76</td>
                                        <td>11:45 AM</td>
                                        <td>RM4.50</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Caramel Macchiato</td>
                                        <td>Coffee</td>
                                        <td>1</td>
                                        <td>80</td>
                                        <td>11:50 AM</td>
                                        <td>RM6.50</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Cheesecake Slice</td>
                                        <td>Pastry</td>
                                        <td>2</td>
                                        <td>20</td>
                                        <td>11:55 AM</td>
                                        <td>RM16.00</td>
                                        <td>
                                            <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="../js/chart-area-demo.js"></script>
    <script src="../js/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="../js/datatables-simple-demo.js"></script>
</body>

</html>