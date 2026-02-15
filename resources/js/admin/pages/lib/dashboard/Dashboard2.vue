<script setup>

import { ref, reactive } from 'vue'
import { route } from 'ziggy-js'
import router from '../../../../router';
import { h } from 'vue'



const selectedCategory = ref(2) // pre-selected by id

  const form = reactive({
    name: 'Ahmed Ullah',
    email: 'ahmed@example.com',
    category: 2,
    description: 'Some text here...',
    agree: true,
    gender: 'male',
    loading: false
  })

//  for table
const columns = [
  { name: 'id', label: '#', width: '10px' },
  { name: 'name', label: 'Name' },
  { name: 'email', label: 'Email' },
];

const users = [
  { 
    id: 1,
    name: (row) => {
      return "<button class='btn btn-sm btn-primary'>Ahmed Sohel</button>"
    },
    email: 'ahmed@test.com', 
  },
  { 
    id: 2, name: 'Rayan Khan', 
    email: 'rayan@test.com', 
  },
];

const actions = [
    { label: 'View', handler: (row) => alert(`View: ${row.name}`) },
    { 
      label: 'Edit', handler: (row) => {
        form.loading = false;
      } 
    },
    { 
      label: 'Delete', handler: (row) => alert(`Delete: ${row.name}`) 
    },
    
];
</script>

<template>
    <BaseTable
        :columns="columns"
        :rows="users"
        :perPage="3"
        :actions="actions"
        :loading="form.loading"
        label="User Table"
        :showSearch="false"
    />

    <br>        
    <br>        

    <!--begin::Container-->
    <div class="container-fluid">
    <!-- Info boxes -->
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon text-bg-primary shadow-sm">
            <i class="bi bi-gear-fill"></i>
            </span>
            <div class="info-box-content">
            <span class="info-box-text">CPU Traffic</span>
            <span class="info-box-number">
                10
                <small>%</small>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon text-bg-danger shadow-sm">
            <i class="bi bi-hand-thumbs-up-fill"></i>
            </span>
            <div class="info-box-content">
            <span class="info-box-text">Likes</span>
            <span class="info-box-number">41,410</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <!-- fix for small devices only -->
        <!-- <div class="clearfix hidden-md-up"></div> -->
        <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon text-bg-success shadow-sm">
            <i class="bi bi-cart-fill"></i>
            </span>
            <div class="info-box-content">
            <span class="info-box-text">Sales</span>
            <span class="info-box-number">760</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon text-bg-warning shadow-sm">
            <i class="bi bi-people-fill"></i>
            </span>
            <div class="info-box-content">
            <span class="info-box-text">New Members</span>
            <span class="info-box-number">2,000</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    <!--begin::Row-->
    <div class="row">
        <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
            <h5 class="card-title">Monthly Recap Report</h5>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                </button>
                <div class="btn-group">
                <button type="button" class="btn btn-tool dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="bi bi-wrench"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" role="menu">
                    <a href="#" class="dropdown-item">Action</a>
                    <a href="#" class="dropdown-item">Another action</a>
                    <a href="#" class="dropdown-item"> Something else here </a>
                    <a class="dropdown-divider"></a>
                    <a href="#" class="dropdown-item">Separated link</a>
                </div>
                </div>
                <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                <i class="bi bi-x-lg"></i>
                </button>
            </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
            <!--begin::Row-->
            <div class="row">
                <div class="col-md-8">
                <p class="text-center">
                    <strong>Sales: 1 Jan, 2023 - 30 Jul, 2023</strong>
                </p>
                <div id="sales-chart" style="min-height: 195px;"><div id="apexcharts87lmqsnq" class="apexcharts-canvas apexcharts87lmqsnq apexcharts-theme-light" style="width: 645px; height: 180px;"><svg id="SvgjsSvg1462" width="645" height="180" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg apexcharts-zoomable" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><rect id="SvgjsRect1469" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe"></rect><g id="SvgjsG1539" class="apexcharts-yaxis" rel="0" transform="translate(15.359375, 0)"><g id="SvgjsG1540" class="apexcharts-yaxis-texts-g"><text id="SvgjsText1542" font-family="Helvetica, Arial, sans-serif" x="20" y="31.5" text-anchor="end" dominant-baseline="auto" font-size="11px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-yaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1543">100</tspan><title>100</title></text><text id="SvgjsText1545" font-family="Helvetica, Arial, sans-serif" x="20" y="55.14" text-anchor="end" dominant-baseline="auto" font-size="11px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-yaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1546">80</tspan><title>80</title></text><text id="SvgjsText1548" font-family="Helvetica, Arial, sans-serif" x="20" y="78.78" text-anchor="end" dominant-baseline="auto" font-size="11px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-yaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1549">60</tspan><title>60</title></text><text id="SvgjsText1551" font-family="Helvetica, Arial, sans-serif" x="20" y="102.42" text-anchor="end" dominant-baseline="auto" font-size="11px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-yaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1552">40</tspan><title>40</title></text><text id="SvgjsText1554" font-family="Helvetica, Arial, sans-serif" x="20" y="126.06" text-anchor="end" dominant-baseline="auto" font-size="11px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-yaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1555">20</tspan><title>20</title></text><text id="SvgjsText1557" font-family="Helvetica, Arial, sans-serif" x="20" y="149.7" text-anchor="end" dominant-baseline="auto" font-size="11px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-yaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1558">0</tspan><title>0</title></text></g></g><g id="SvgjsG1464" class="apexcharts-inner apexcharts-graphical" transform="translate(45.359375, 30)"><defs id="SvgjsDefs1463"><clipPath id="gridRectMask87lmqsnq"><rect id="SvgjsRect1474" width="597.640625" height="122.19999999999999" x="-4" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="forecastMask87lmqsnq"></clipPath><clipPath id="nonForecastMask87lmqsnq"></clipPath><clipPath id="gridRectMarkerMask87lmqsnq"><rect id="SvgjsRect1475" width="593.640625" height="122.19999999999999" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><linearGradient id="SvgjsLinearGradient1480" x1="0" y1="0" x2="0" y2="1"><stop id="SvgjsStop1481" stop-opacity="0.65" stop-color="rgba(13,110,253,0.65)" offset="0"></stop><stop id="SvgjsStop1482" stop-opacity="0.5" stop-color="rgba(134,183,254,0.5)" offset="1"></stop><stop id="SvgjsStop1483" stop-opacity="0.5" stop-color="rgba(134,183,254,0.5)" offset="1"></stop></linearGradient><linearGradient id="SvgjsLinearGradient1489" x1="0" y1="0" x2="0" y2="1"><stop id="SvgjsStop1490" stop-opacity="0.65" stop-color="rgba(32,201,151,0.65)" offset="0"></stop><stop id="SvgjsStop1491" stop-opacity="0.5" stop-color="rgba(144,228,203,0.5)" offset="1"></stop><stop id="SvgjsStop1492" stop-opacity="0.5" stop-color="rgba(144,228,203,0.5)" offset="1"></stop></linearGradient></defs><line id="SvgjsLine1470" x1="0" y1="0" x2="0" y2="118.19999999999999" stroke="#b6b6b6" stroke-dasharray="3" stroke-linecap="butt" class="apexcharts-xcrosshairs" x="0" y="0" width="1" height="118.19999999999999" fill="#b1b9c4" filter="none" fill-opacity="0.9" stroke-width="1"></line><line id="SvgjsLine1499" x1="0" y1="119.19999999999999" x2="0" y2="125.19999999999999" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-xaxis-tick"></line><line id="SvgjsLine1500" x1="100.98817334254144" y1="119.19999999999999" x2="100.98817334254144" y2="125.19999999999999" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-xaxis-tick"></line><line id="SvgjsLine1501" x1="192.20329765193372" y1="119.19999999999999" x2="192.20329765193372" y2="125.19999999999999" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-xaxis-tick"></line><line id="SvgjsLine1502" x1="293.19147099447514" y1="119.19999999999999" x2="293.19147099447514" y2="125.19999999999999" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-xaxis-tick"></line><line id="SvgjsLine1503" x1="390.9219613259669" y1="119.19999999999999" x2="390.9219613259669" y2="125.19999999999999" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-xaxis-tick"></line><line id="SvgjsLine1504" x1="491.91013466850836" y1="119.19999999999999" x2="491.91013466850836" y2="125.19999999999999" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-xaxis-tick"></line><g id="SvgjsG1495" class="apexcharts-grid"><g id="SvgjsG1496" class="apexcharts-gridlines-horizontal"><line id="SvgjsLine1506" x1="0" y1="23.639999999999997" x2="589.640625" y2="23.639999999999997" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1507" x1="0" y1="47.279999999999994" x2="589.640625" y2="47.279999999999994" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1508" x1="0" y1="70.91999999999999" x2="589.640625" y2="70.91999999999999" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1509" x1="0" y1="94.55999999999999" x2="589.640625" y2="94.55999999999999" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line></g><g id="SvgjsG1497" class="apexcharts-gridlines-vertical"></g><line id="SvgjsLine1512" x1="0" y1="118.19999999999999" x2="589.640625" y2="118.19999999999999" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line><line id="SvgjsLine1511" x1="0" y1="1" x2="0" y2="118.19999999999999" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line></g><g id="SvgjsG1498" class="apexcharts-grid-borders"><line id="SvgjsLine1505" x1="0" y1="0" x2="589.640625" y2="0" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1510" x1="0" y1="118.19999999999999" x2="589.640625" y2="118.19999999999999" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1538" x1="0" y1="119.19999999999999" x2="589.640625" y2="119.19999999999999" stroke="#e0e0e0" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt"></line></g><g id="SvgjsG1476" class="apexcharts-area-series apexcharts-plot-series"><g id="SvgjsG1477" class="apexcharts-series" seriesName="DigitalxGoods" data:longestSeries="true" rel="1" data:realIndex="0"><path id="SvgjsPath1484" d="M 0 118.19999999999999 L 0 85.10399999999998C 35.345860669889504 85.10399999999998 65.64231267265194 61.464 100.98817334254144 61.464C 132.91346685082874 61.464 160.27800414364643 70.91999999999999 192.20329765193372 70.91999999999999C 227.5491583218232 70.91999999999999 257.84561032458566 95.74199999999999 293.19147099447514 95.74199999999999C 327.39714261049727 95.74199999999999 356.71628970994476 16.548000000000002 390.9219613259669 16.548000000000002C 426.26782199585637 16.548000000000002 456.56427399861883 86.286 491.9101346685083 86.286C 526.1158062845304 86.286 555.4349533839779 11.820000000000007 589.640625 11.820000000000007C 589.640625 11.820000000000007 589.640625 11.820000000000007 589.640625 118.19999999999999M 589.640625 11.820000000000007z" fill="url(#SvgjsLinearGradient1480)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMask87lmqsnq)" pathTo="M 0 118.19999999999999 L 0 85.10399999999998C 35.345860669889504 85.10399999999998 65.64231267265194 61.464 100.98817334254144 61.464C 132.91346685082874 61.464 160.27800414364643 70.91999999999999 192.20329765193372 70.91999999999999C 227.5491583218232 70.91999999999999 257.84561032458566 95.74199999999999 293.19147099447514 95.74199999999999C 327.39714261049727 95.74199999999999 356.71628970994476 16.548000000000002 390.9219613259669 16.548000000000002C 426.26782199585637 16.548000000000002 456.56427399861883 86.286 491.9101346685083 86.286C 526.1158062845304 86.286 555.4349533839779 11.820000000000007 589.640625 11.820000000000007C 589.640625 11.820000000000007 589.640625 11.820000000000007 589.640625 118.19999999999999M 589.640625 11.820000000000007z" pathFrom="M -1 118.19999999999999 L -1 118.19999999999999 L 100.98817334254144 118.19999999999999 L 192.20329765193372 118.19999999999999 L 293.19147099447514 118.19999999999999 L 390.9219613259669 118.19999999999999 L 491.9101346685083 118.19999999999999 L 589.640625 118.19999999999999"></path><path id="SvgjsPath1485" d="M 0 85.10399999999998C 35.345860669889504 85.10399999999998 65.64231267265194 61.464 100.98817334254144 61.464C 132.91346685082874 61.464 160.27800414364643 70.91999999999999 192.20329765193372 70.91999999999999C 227.5491583218232 70.91999999999999 257.84561032458566 95.74199999999999 293.19147099447514 95.74199999999999C 327.39714261049727 95.74199999999999 356.71628970994476 16.548000000000002 390.9219613259669 16.548000000000002C 426.26782199585637 16.548000000000002 456.56427399861883 86.286 491.9101346685083 86.286C 526.1158062845304 86.286 555.4349533839779 11.820000000000007 589.640625 11.820000000000007" fill="none" fill-opacity="1" stroke="#0d6efd" stroke-opacity="1" stroke-linecap="butt" stroke-width="4" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMask87lmqsnq)" pathTo="M 0 85.10399999999998C 35.345860669889504 85.10399999999998 65.64231267265194 61.464 100.98817334254144 61.464C 132.91346685082874 61.464 160.27800414364643 70.91999999999999 192.20329765193372 70.91999999999999C 227.5491583218232 70.91999999999999 257.84561032458566 95.74199999999999 293.19147099447514 95.74199999999999C 327.39714261049727 95.74199999999999 356.71628970994476 16.548000000000002 390.9219613259669 16.548000000000002C 426.26782199585637 16.548000000000002 456.56427399861883 86.286 491.9101346685083 86.286C 526.1158062845304 86.286 555.4349533839779 11.820000000000007 589.640625 11.820000000000007" pathFrom="M -1 118.19999999999999 L -1 118.19999999999999 L 100.98817334254144 118.19999999999999 L 192.20329765193372 118.19999999999999 L 293.19147099447514 118.19999999999999 L 390.9219613259669 118.19999999999999 L 491.9101346685083 118.19999999999999 L 589.640625 118.19999999999999" fill-rule="evenodd"></path><g id="SvgjsG1478" class="apexcharts-series-markers-wrap" data:realIndex="0"><g class="apexcharts-series-markers"><circle id="SvgjsCircle1562" r="0" cx="0" cy="0" class="apexcharts-marker wri2mmjtx no-pointer-events" stroke="#ffffff" fill="#0d6efd" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" default-marker-size="0"></circle></g></g></g><g id="SvgjsG1486" class="apexcharts-series" seriesName="Electronics" data:longestSeries="true" rel="2" data:realIndex="1"><path id="SvgjsPath1493" d="M 0 118.19999999999999 L 0 41.370000000000005C 35.345860669889504 41.370000000000005 65.64231267265194 48.462 100.98817334254144 48.462C 132.91346685082874 48.462 160.27800414364643 23.64 192.20329765193372 23.64C 227.5491583218232 23.64 257.84561032458566 22.458 293.19147099447514 22.458C 327.39714261049727 22.458 356.71628970994476 52.007999999999996 390.9219613259669 52.007999999999996C 426.26782199585637 52.007999999999996 456.56427399861883 53.19 491.9101346685083 53.19C 526.1158062845304 53.19 555.4349533839779 70.91999999999999 589.640625 70.91999999999999C 589.640625 70.91999999999999 589.640625 70.91999999999999 589.640625 118.19999999999999M 589.640625 70.91999999999999z" fill="url(#SvgjsLinearGradient1489)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-area" index="1" clip-path="url(#gridRectMask87lmqsnq)" pathTo="M 0 118.19999999999999 L 0 41.370000000000005C 35.345860669889504 41.370000000000005 65.64231267265194 48.462 100.98817334254144 48.462C 132.91346685082874 48.462 160.27800414364643 23.64 192.20329765193372 23.64C 227.5491583218232 23.64 257.84561032458566 22.458 293.19147099447514 22.458C 327.39714261049727 22.458 356.71628970994476 52.007999999999996 390.9219613259669 52.007999999999996C 426.26782199585637 52.007999999999996 456.56427399861883 53.19 491.9101346685083 53.19C 526.1158062845304 53.19 555.4349533839779 70.91999999999999 589.640625 70.91999999999999C 589.640625 70.91999999999999 589.640625 70.91999999999999 589.640625 118.19999999999999M 589.640625 70.91999999999999z" pathFrom="M -1 118.19999999999999 L -1 118.19999999999999 L 100.98817334254144 118.19999999999999 L 192.20329765193372 118.19999999999999 L 293.19147099447514 118.19999999999999 L 390.9219613259669 118.19999999999999 L 491.9101346685083 118.19999999999999 L 589.640625 118.19999999999999"></path><path id="SvgjsPath1494" d="M 0 41.370000000000005C 35.345860669889504 41.370000000000005 65.64231267265194 48.462 100.98817334254144 48.462C 132.91346685082874 48.462 160.27800414364643 23.64 192.20329765193372 23.64C 227.5491583218232 23.64 257.84561032458566 22.458 293.19147099447514 22.458C 327.39714261049727 22.458 356.71628970994476 52.007999999999996 390.9219613259669 52.007999999999996C 426.26782199585637 52.007999999999996 456.56427399861883 53.19 491.9101346685083 53.19C 526.1158062845304 53.19 555.4349533839779 70.91999999999999 589.640625 70.91999999999999" fill="none" fill-opacity="1" stroke="#20c997" stroke-opacity="1" stroke-linecap="butt" stroke-width="4" stroke-dasharray="0" class="apexcharts-area" index="1" clip-path="url(#gridRectMask87lmqsnq)" pathTo="M 0 41.370000000000005C 35.345860669889504 41.370000000000005 65.64231267265194 48.462 100.98817334254144 48.462C 132.91346685082874 48.462 160.27800414364643 23.64 192.20329765193372 23.64C 227.5491583218232 23.64 257.84561032458566 22.458 293.19147099447514 22.458C 327.39714261049727 22.458 356.71628970994476 52.007999999999996 390.9219613259669 52.007999999999996C 426.26782199585637 52.007999999999996 456.56427399861883 53.19 491.9101346685083 53.19C 526.1158062845304 53.19 555.4349533839779 70.91999999999999 589.640625 70.91999999999999" pathFrom="M -1 118.19999999999999 L -1 118.19999999999999 L 100.98817334254144 118.19999999999999 L 192.20329765193372 118.19999999999999 L 293.19147099447514 118.19999999999999 L 390.9219613259669 118.19999999999999 L 491.9101346685083 118.19999999999999 L 589.640625 118.19999999999999" fill-rule="evenodd"></path><g id="SvgjsG1487" class="apexcharts-series-markers-wrap" data:realIndex="1"><g class="apexcharts-series-markers"><circle id="SvgjsCircle1563" r="0" cx="0" cy="0" class="apexcharts-marker w14eomg2uj no-pointer-events" stroke="#ffffff" fill="#20c997" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" default-marker-size="0"></circle></g></g></g><g id="SvgjsG1479" class="apexcharts-datalabels" data:realIndex="0"></g><g id="SvgjsG1488" class="apexcharts-datalabels" data:realIndex="1"></g></g><line id="SvgjsLine1513" x1="0" y1="0" x2="589.640625" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1514" x1="0" y1="0" x2="589.640625" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG1515" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG1516" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"><text id="SvgjsText1518" font-family="Helvetica, Arial, sans-serif" x="0" y="147.2" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1519">Jan '23</tspan><title>Jan '23</title></text><text id="SvgjsText1521" font-family="Helvetica, Arial, sans-serif" x="100.98817334254144" y="147.2" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1522">Feb '23</tspan><title>Feb '23</title></text><text id="SvgjsText1524" font-family="Helvetica, Arial, sans-serif" x="192.20329765193372" y="147.2" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1525">Mar '23</tspan><title>Mar '23</title></text><text id="SvgjsText1527" font-family="Helvetica, Arial, sans-serif" x="293.19147099447514" y="147.2" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1528">Apr '23</tspan><title>Apr '23</title></text><text id="SvgjsText1530" font-family="Helvetica, Arial, sans-serif" x="390.9219613259669" y="147.2" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1531">May '23</tspan><title>May '23</title></text><text id="SvgjsText1533" font-family="Helvetica, Arial, sans-serif" x="491.91013466850836" y="147.2" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1534">Jun '23</tspan><title>Jun '23</title></text><text id="SvgjsText1536" font-family="Helvetica, Arial, sans-serif" x="589.6406250000001" y="147.2" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan1537"></tspan><title></title></text></g></g><g id="SvgjsG1559" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG1560" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG1561" class="apexcharts-point-annotations"></g><rect id="SvgjsRect1564" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe" class="apexcharts-zoom-rect"></rect><rect id="SvgjsRect1565" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe" class="apexcharts-selection-rect"></rect></g><g id="SvgjsG1465" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend" style="max-height: 90px;"></div><div class="apexcharts-tooltip apexcharts-theme-light"><div class="apexcharts-tooltip-title" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"></div><div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(13, 110, 253);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div><div class="apexcharts-tooltip-series-group" style="order: 2;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(32, 201, 151);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div><div class="apexcharts-xaxistooltip apexcharts-xaxistooltip-bottom apexcharts-theme-light"><div class="apexcharts-xaxistooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"></div></div><div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light"><div class="apexcharts-yaxistooltip-text"></div></div></div></div>
                </div>
                <!-- /.col -->
                <div class="col-md-4">
                <p class="text-center"><strong>Goal Completion</strong></p>
                <div class="progress-group">
                    Add Products to Cart
                    <span class="float-end"><b>160</b>/200</span>
                    <div class="progress progress-sm">
                    <div class="progress-bar text-bg-primary" style="width: 80%"></div>
                    </div>
                </div>
                <!-- /.progress-group -->
                <div class="progress-group">
                    Complete Purchase
                    <span class="float-end"><b>310</b>/400</span>
                    <div class="progress progress-sm">
                    <div class="progress-bar text-bg-danger" style="width: 75%"></div>
                    </div>
                </div>
                <!-- /.progress-group -->
                <div class="progress-group">
                    <span class="progress-text">Visit Premium Page</span>
                    <span class="float-end"><b>480</b>/800</span>
                    <div class="progress progress-sm">
                    <div class="progress-bar text-bg-success" style="width: 60%"></div>
                    </div>
                </div>
                <!-- /.progress-group -->
                <div class="progress-group">
                    Send Inquiries
                    <span class="float-end"><b>250</b>/500</span>
                    <div class="progress progress-sm">
                    <div class="progress-bar text-bg-warning" style="width: 50%"></div>
                    </div>
                </div>
                <!-- /.progress-group -->
                </div>
                <!-- /.col -->
            </div>
            <!--end::Row-->
            </div>
            <!-- ./card-body -->
            <div class="card-footer">
            <!--begin::Row-->
            <div class="row">
                <div class="col-md-3 col-6">
                <div class="text-center border-end">
                    <span class="text-success">
                    <i class="bi bi-caret-up-fill"></i> 17%
                    </span>
                    <h5 class="fw-bold mb-0">$35,210.43</h5>
                    <span class="text-uppercase">TOTAL REVENUE</span>
                </div>
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-6">
                <div class="text-center border-end">
                    <span class="text-info"> <i class="bi bi-caret-left-fill"></i> 0% </span>
                    <h5 class="fw-bold mb-0">$10,390.90</h5>
                    <span class="text-uppercase">TOTAL COST</span>
                </div>
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-6">
                <div class="text-center border-end">
                    <span class="text-success">
                    <i class="bi bi-caret-up-fill"></i> 20%
                    </span>
                    <h5 class="fw-bold mb-0">$24,813.53</h5>
                    <span class="text-uppercase">TOTAL PROFIT</span>
                </div>
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-6">
                <div class="text-center">
                    <span class="text-danger">
                    <i class="bi bi-caret-down-fill"></i> 18%
                    </span>
                    <h5 class="fw-bold mb-0">1200</h5>
                    <span class="text-uppercase">GOAL COMPLETIONS</span>
                </div>
                </div>
            </div>
            <!--end::Row-->
            </div>
            <!-- /.card-footer -->
        </div>
        <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!--end::Row-->
    <!--begin::Row-->
    <div class="row">
        <!-- Start col -->
        <div class="col-md-8">
        <!--begin::Row-->
        <div class="row g-4 mb-4">
            <div class="col-md-6">
            <!-- DIRECT CHAT -->
            <div class="card direct-chat direct-chat-warning">
                <div class="card-header">
                <h3 class="card-title">Direct Chat</h3>
                <div class="card-tools">
                    <span title="3 New Messages" class="badge text-bg-warning"> 3 </span>
                    <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                    <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                    <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                    </button>
                    <button type="button" class="btn btn-tool" title="Contacts" data-lte-toggle="chat-pane">
                    <i class="bi bi-chat-text-fill"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                    <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                <!-- Conversations are loaded here -->
                <div class="direct-chat-messages">
                    <!-- Message. Default to the start -->
                    <div class="direct-chat-msg">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-name float-start"> Alexander Pierce </span>
                        <span class="direct-chat-timestamp float-end"> 23 Jan 2:00 pm </span>
                    </div>
                    <!-- /.direct-chat-infos -->
                    <img class="direct-chat-img" src="admin/v1/assets/img/user1-128x128.jpg" alt="message user image">
                    <!-- /.direct-chat-img -->
                    <div class="direct-chat-text">
                        Is this template really for free? That's unbelievable!
                    </div>
                    <!-- /.direct-chat-text -->
                    </div>
                    <!-- /.direct-chat-msg -->
                    <!-- Message to the end -->
                    <div class="direct-chat-msg end">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-name float-end"> Sarah Bullock </span>
                        <span class="direct-chat-timestamp float-start">
                        23 Jan 2:05 pm
                        </span>
                    </div>
                    <!-- /.direct-chat-infos -->
                    <img class="direct-chat-img" src="admin/v1/assets/img/user3-128x128.jpg" alt="message user image">
                    <!-- /.direct-chat-img -->
                    <div class="direct-chat-text">You better believe it!</div>
                    <!-- /.direct-chat-text -->
                    </div>
                    <!-- /.direct-chat-msg -->
                    <!-- Message. Default to the start -->
                    <div class="direct-chat-msg">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-name float-start"> Alexander Pierce </span>
                        <span class="direct-chat-timestamp float-end"> 23 Jan 5:37 pm </span>
                    </div>
                    <!-- /.direct-chat-infos -->
                    <img class="direct-chat-img" src="admin/v1/assets/img/user1-128x128.jpg" alt="message user image">
                    <!-- /.direct-chat-img -->
                    <div class="direct-chat-text">
                        Working with AdminLTE on a great new app! Wanna join?
                    </div>
                    <!-- /.direct-chat-text -->
                    </div>
                    <!-- /.direct-chat-msg -->
                    <!-- Message to the end -->
                    <div class="direct-chat-msg end">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-name float-end"> Sarah Bullock </span>
                        <span class="direct-chat-timestamp float-start">
                        23 Jan 6:10 pm
                        </span>
                    </div>
                    <!-- /.direct-chat-infos -->
                    <img class="direct-chat-img" src="admin/v1/assets/img/user3-128x128.jpg" alt="message user image">
                    <!-- /.direct-chat-img -->
                    <div class="direct-chat-text">I would love to.</div>
                    <!-- /.direct-chat-text -->
                    </div>
                    <!-- /.direct-chat-msg -->
                </div>
                <!-- /.direct-chat-messages-->
                <!-- Contacts are loaded here -->
                <div class="direct-chat-contacts">
                    <ul class="contacts-list">
                    <li>
                        <a href="#">
                        <img class="contacts-list-img" src="admin/v1/assets/img/user1-128x128.jpg" alt="User Avatar">
                        <div class="contacts-list-info">
                            <span class="contacts-list-name">
                            Count Dracula
                            <small class="contacts-list-date float-end"> 2/28/2023 </small>
                            </span>
                            <span class="contacts-list-msg">
                            How have you been? I was...
                            </span>
                        </div>
                        <!-- /.contacts-list-info -->
                        </a>
                    </li>
                    <!-- End Contact Item -->
                    <li>
                        <a href="#">
                        <img class="contacts-list-img" src="admin/v1/assets/img/user7-128x128.jpg" alt="User Avatar">
                        <div class="contacts-list-info">
                            <span class="contacts-list-name">
                            Sarah Doe
                            <small class="contacts-list-date float-end"> 2/23/2023 </small>
                            </span>
                            <span class="contacts-list-msg"> I will be waiting for... </span>
                        </div>
                        <!-- /.contacts-list-info -->
                        </a>
                    </li>
                    <!-- End Contact Item -->
                    <li>
                        <a href="#">
                        <img class="contacts-list-img" src="admin/v1/assets/img/user3-128x128.jpg" alt="User Avatar">
                        <div class="contacts-list-info">
                            <span class="contacts-list-name">
                            Nadia Jolie
                            <small class="contacts-list-date float-end"> 2/20/2023 </small>
                            </span>
                            <span class="contacts-list-msg"> I'll call you back at... </span>
                        </div>
                        <!-- /.contacts-list-info -->
                        </a>
                    </li>
                    <!-- End Contact Item -->
                    <li>
                        <a href="#">
                        <img class="contacts-list-img" src="admin/v1/assets/img/user5-128x128.jpg" alt="User Avatar">
                        <div class="contacts-list-info">
                            <span class="contacts-list-name">
                            Nora S. Vans
                            <small class="contacts-list-date float-end"> 2/10/2023 </small>
                            </span>
                            <span class="contacts-list-msg"> Where is your new... </span>
                        </div>
                        <!-- /.contacts-list-info -->
                        </a>
                    </li>
                    <!-- End Contact Item -->
                    <li>
                        <a href="#">
                        <img class="contacts-list-img" src="admin/v1/assets/img/user6-128x128.jpg" alt="User Avatar">
                        <div class="contacts-list-info">
                            <span class="contacts-list-name">
                            John K.
                            <small class="contacts-list-date float-end"> 1/27/2023 </small>
                            </span>
                            <span class="contacts-list-msg"> Can I take a look at... </span>
                        </div>
                        <!-- /.contacts-list-info -->
                        </a>
                    </li>
                    <!-- End Contact Item -->
                    <li>
                        <a href="#">
                        <img class="contacts-list-img" src="admin/v1/assets/img/user8-128x128.jpg" alt="User Avatar">
                        <div class="contacts-list-info">
                            <span class="contacts-list-name">
                            Kenneth M.
                            <small class="contacts-list-date float-end"> 1/4/2023 </small>
                            </span>
                            <span class="contacts-list-msg"> Never mind I found... </span>
                        </div>
                        <!-- /.contacts-list-info -->
                        </a>
                    </li>
                    <!-- End Contact Item -->
                    </ul>
                    <!-- /.contacts-list -->
                </div>
                <!-- /.direct-chat-pane -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                <form action="#" method="post">
                    <div class="input-group">
                    <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                    <span class="input-group-append">
                        <button type="button" class="btn btn-warning">Send</button>
                    </span>
                    </div>
                </form>
                </div>
                <!-- /.card-footer-->
            </div>
            <!-- /.direct-chat -->
            </div>
            <!-- /.col -->
            <div class="col-md-6">
            <!-- USERS LIST -->
            <div class="card">
                <div class="card-header">
                <h3 class="card-title">Latest Members</h3>
                <div class="card-tools">
                    <span class="badge text-bg-danger"> 8 New Members </span>
                    <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                    <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                    <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                    <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                <div class="row text-center m-1">
                    <div class="col-3 p-2">
                    <img class="img-fluid rounded-circle" src="admin/v1/assets/img/user1-128x128.jpg" alt="User Image">
                    <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0" href="#">
                        Alexander Pierce
                    </a>
                    <div class="fs-8">Today</div>
                    </div>
                    <div class="col-3 p-2">
                    <img class="img-fluid rounded-circle" src="admin/v1/assets/img/user1-128x128.jpg" alt="User Image">
                    <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0" href="#">
                        Norman
                    </a>
                    <div class="fs-8">Yesterday</div>
                    </div>
                    <div class="col-3 p-2">
                    <img class="img-fluid rounded-circle" src="admin/v1/assets/img/user7-128x128.jpg" alt="User Image">
                    <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0" href="#">
                        Jane
                    </a>
                    <div class="fs-8">12 Jan</div>
                    </div>
                    <div class="col-3 p-2">
                    <img class="img-fluid rounded-circle" src="admin/v1/assets/img/user6-128x128.jpg" alt="User Image">
                    <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0" href="#">
                        John
                    </a>
                    <div class="fs-8">12 Jan</div>
                    </div>
                    <div class="col-3 p-2">
                    <img class="img-fluid rounded-circle" src="admin/v1/assets/img/user2-160x160.jpg" alt="User Image">
                    <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0" href="#">
                        Alexander
                    </a>
                    <div class="fs-8">13 Jan</div>
                    </div>
                    <div class="col-3 p-2">
                    <img class="img-fluid rounded-circle" src="admin/v1/assets/img/user5-128x128.jpg" alt="User Image">
                    <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0" href="#">
                        Sarah
                    </a>
                    <div class="fs-8">14 Jan</div>
                    </div>
                    <div class="col-3 p-2">
                    <img class="img-fluid rounded-circle" src="admin/v1/assets/img/user4-128x128.jpg" alt="User Image">
                    <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0" href="#">
                        Nora
                    </a>
                    <div class="fs-8">15 Jan</div>
                    </div>
                    <div class="col-3 p-2">
                    <img class="img-fluid rounded-circle" src="admin/v1/assets/img/user3-128x128.jpg" alt="User Image">
                    <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0" href="#">
                        Nadia
                    </a>
                    <div class="fs-8">15 Jan</div>
                    </div>
                </div>
                <!-- /.users-list -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer text-center">
                <a href="javascript:" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">View All Users</a>
                </div>
                <!-- /.card-footer -->
            </div>
            <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!--end::Row-->
        <!--begin::Latest Order Widget-->
        <div class="card">
            <div class="card-header">
            <h3 class="card-title">Latest Orders</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                </button>
                <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                <i class="bi bi-x-lg"></i>
                </button>
            </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table m-0">
                <thead>
                    <tr>
                    <th>Order ID</th>
                    <th>Item</th>
                    <th>Status</th>
                    <th>Popularity</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <td>
                        <a href="pages/examples/invoice.html" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR9842</a>
                    </td>
                    <td>Call of Duty IV</td>
                    <td><span class="badge text-bg-success"> Shipped </span></td>
                    <td><div id="table-sparkline-1" style="min-height: 30px;"><div id="apexcharts9ciw77cd" class="apexcharts-canvas apexcharts9ciw77cd apexcharts-theme-light" style="width: 150px; height: 30px;"><svg id="SvgjsSvg1567" width="150" height="30" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><rect id="SvgjsRect1572" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe"></rect><g id="SvgjsG1608" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g><g id="SvgjsG1569" class="apexcharts-inner apexcharts-graphical" transform="translate(0, 0)"><defs id="SvgjsDefs1568"><clipPath id="gridRectMask9ciw77cd"><rect id="SvgjsRect1574" width="156" height="32" x="-3" y="-1" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="forecastMask9ciw77cd"></clipPath><clipPath id="nonForecastMask9ciw77cd"></clipPath><clipPath id="gridRectMarkerMask9ciw77cd"><rect id="SvgjsRect1575" width="154" height="34" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><line id="SvgjsLine1573" x1="0" y1="0" x2="0" y2="30" stroke="#b6b6b6" stroke-dasharray="3" stroke-linecap="butt" class="apexcharts-xcrosshairs" x="0" y="0" width="1" height="30" fill="#b1b9c4" filter="none" fill-opacity="0.9" stroke-width="1"></line><g id="SvgjsG1581" class="apexcharts-grid"><g id="SvgjsG1582" class="apexcharts-gridlines-horizontal" style="display: none;"><line id="SvgjsLine1586" x1="0" y1="6" x2="150" y2="6" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1587" x1="0" y1="12" x2="150" y2="12" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1588" x1="0" y1="18" x2="150" y2="18" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1589" x1="0" y1="24" x2="150" y2="24" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line></g><g id="SvgjsG1583" class="apexcharts-gridlines-vertical" style="display: none;"></g><line id="SvgjsLine1592" x1="0" y1="30" x2="150" y2="30" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line><line id="SvgjsLine1591" x1="0" y1="1" x2="0" y2="30" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line></g><g id="SvgjsG1584" class="apexcharts-grid-borders" style="display: none;"><line id="SvgjsLine1585" x1="0" y1="0" x2="150" y2="0" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1590" x1="0" y1="30" x2="150" y2="30" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line></g><g id="SvgjsG1576" class="apexcharts-line-series apexcharts-plot-series"><g id="SvgjsG1577" class="apexcharts-series" seriesName="series-1" data:longestSeries="true" rel="1" data:realIndex="0"><path id="SvgjsPath1580" d="M 0 22.5 L 15 10.2 L 30 17.700000000000003 L 45 3.3000000000000007 L 60 11.100000000000001 L 75 22.5 L 90 16.8 L 105 26.4 L 120 19.200000000000003 L 135 27.3 L 150 13.8" fill="none" fill-opacity="1" stroke="var(--bs-primary)" stroke-opacity="1" stroke-linecap="butt" stroke-width="2" stroke-dasharray="0" class="apexcharts-line" index="0" clip-path="url(#gridRectMask9ciw77cd)" pathTo="M 0 22.5 L 15 10.2 L 30 17.700000000000003 L 45 3.3000000000000007 L 60 11.100000000000001 L 75 22.5 L 90 16.8 L 105 26.4 L 120 19.200000000000003 L 135 27.3 L 150 13.8" pathFrom="M -1 30 L -1 30 L 15 30 L 30 30 L 45 30 L 60 30 L 75 30 L 90 30 L 105 30 L 120 30 L 135 30 L 150 30" fill-rule="evenodd"></path><g id="SvgjsG1578" class="apexcharts-series-markers-wrap" data:realIndex="0"><g class="apexcharts-series-markers"><circle id="SvgjsCircle1612" r="0" cx="0" cy="0" class="apexcharts-marker wbb6uetj8 no-pointer-events" stroke="#ffffff" fill="var(--bs-primary)" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" default-marker-size="0"></circle></g></g></g><g id="SvgjsG1579" class="apexcharts-datalabels" data:realIndex="0"></g></g><line id="SvgjsLine1593" x1="0" y1="0" x2="150" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1594" x1="0" y1="0" x2="150" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG1595" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG1596" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g></g><g id="SvgjsG1609" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG1610" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG1611" class="apexcharts-point-annotations"></g></g><g id="SvgjsG1570" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend" style="max-height: 15px;"></div><div class="apexcharts-tooltip apexcharts-theme-light"><div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: var(--bs-primary);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div><div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light"><div class="apexcharts-yaxistooltip-text"></div></div></div></div></td>
                    </tr>
                    <tr>
                    <td>
                        <a href="pages/examples/invoice.html" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR1848</a>
                    </td>
                    <td>Samsung Smart TV</td>
                    <td><span class="badge text-bg-warning">Pending</span></td>
                    <td><div id="table-sparkline-2" style="min-height: 30px;"><div id="apexchartstiu78epo" class="apexcharts-canvas apexchartstiu78epo apexcharts-theme-light" style="width: 150px; height: 30px;"><svg id="SvgjsSvg1614" width="150" height="30" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><rect id="SvgjsRect1619" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe"></rect><g id="SvgjsG1654" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g><g id="SvgjsG1616" class="apexcharts-inner apexcharts-graphical" transform="translate(0, 0)"><defs id="SvgjsDefs1615"><clipPath id="gridRectMasktiu78epo"><rect id="SvgjsRect1621" width="156" height="32" x="-3" y="-1" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="forecastMasktiu78epo"></clipPath><clipPath id="nonForecastMasktiu78epo"></clipPath><clipPath id="gridRectMarkerMasktiu78epo"><rect id="SvgjsRect1622" width="154" height="34" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><line id="SvgjsLine1620" x1="0" y1="0" x2="0" y2="30" stroke="#b6b6b6" stroke-dasharray="3" stroke-linecap="butt" class="apexcharts-xcrosshairs" x="0" y="0" width="1" height="30" fill="#b1b9c4" filter="none" fill-opacity="0.9" stroke-width="1"></line><g id="SvgjsG1628" class="apexcharts-grid"><g id="SvgjsG1629" class="apexcharts-gridlines-horizontal" style="display: none;"><line id="SvgjsLine1633" x1="0" y1="7.5" x2="150" y2="7.5" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1634" x1="0" y1="15" x2="150" y2="15" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1635" x1="0" y1="22.5" x2="150" y2="22.5" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line></g><g id="SvgjsG1630" class="apexcharts-gridlines-vertical" style="display: none;"></g><line id="SvgjsLine1638" x1="0" y1="30" x2="150" y2="30" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line><line id="SvgjsLine1637" x1="0" y1="1" x2="0" y2="30" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line></g><g id="SvgjsG1631" class="apexcharts-grid-borders" style="display: none;"><line id="SvgjsLine1632" x1="0" y1="0" x2="150" y2="0" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1636" x1="0" y1="30" x2="150" y2="30" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line></g><g id="SvgjsG1623" class="apexcharts-line-series apexcharts-plot-series"><g id="SvgjsG1624" class="apexcharts-series" seriesName="series-1" data:longestSeries="true" rel="1" data:realIndex="0"><path id="SvgjsPath1627" d="M 0 25.5 L 15 9 L 30 22.125 L 45 15.375 L 60 2.625 L 75 13.125 L 90 6 L 105 10.5 L 120 16.5 L 135 7.875 L 150 13.5" fill="none" fill-opacity="1" stroke="var(--bs-primary)" stroke-opacity="1" stroke-linecap="butt" stroke-width="2" stroke-dasharray="0" class="apexcharts-line" index="0" clip-path="url(#gridRectMasktiu78epo)" pathTo="M 0 25.5 L 15 9 L 30 22.125 L 45 15.375 L 60 2.625 L 75 13.125 L 90 6 L 105 10.5 L 120 16.5 L 135 7.875 L 150 13.5" pathFrom="M -1 30 L -1 30 L 15 30 L 30 30 L 45 30 L 60 30 L 75 30 L 90 30 L 105 30 L 120 30 L 135 30 L 150 30" fill-rule="evenodd"></path><g id="SvgjsG1625" class="apexcharts-series-markers-wrap" data:realIndex="0"><g class="apexcharts-series-markers"><circle id="SvgjsCircle1658" r="0" cx="0" cy="0" class="apexcharts-marker wwswqxrnf no-pointer-events" stroke="#ffffff" fill="var(--bs-primary)" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" default-marker-size="0"></circle></g></g></g><g id="SvgjsG1626" class="apexcharts-datalabels" data:realIndex="0"></g></g><line id="SvgjsLine1639" x1="0" y1="0" x2="150" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1640" x1="0" y1="0" x2="150" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG1641" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG1642" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g></g><g id="SvgjsG1655" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG1656" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG1657" class="apexcharts-point-annotations"></g></g><g id="SvgjsG1617" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend" style="max-height: 15px;"></div><div class="apexcharts-tooltip apexcharts-theme-light"><div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: var(--bs-primary);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div><div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light"><div class="apexcharts-yaxistooltip-text"></div></div></div></div></td>
                    </tr>
                    <tr>
                    <td>
                        <a href="pages/examples/invoice.html" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR7429</a>
                    </td>
                    <td>iPhone 6 Plus</td>
                    <td><span class="badge text-bg-danger"> Delivered </span></td>
                    <td><div id="table-sparkline-3" style="min-height: 30px;"><div id="apexcharts169vazcf" class="apexcharts-canvas apexcharts169vazcf apexcharts-theme-light" style="width: 150px; height: 30px;"><svg id="SvgjsSvg1660" width="150" height="30" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><rect id="SvgjsRect1665" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe"></rect><g id="SvgjsG1702" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g><g id="SvgjsG1662" class="apexcharts-inner apexcharts-graphical" transform="translate(0, 0)"><defs id="SvgjsDefs1661"><clipPath id="gridRectMask169vazcf"><rect id="SvgjsRect1667" width="156" height="32" x="-3" y="-1" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="forecastMask169vazcf"></clipPath><clipPath id="nonForecastMask169vazcf"></clipPath><clipPath id="gridRectMarkerMask169vazcf"><rect id="SvgjsRect1668" width="154" height="34" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><line id="SvgjsLine1666" x1="0" y1="0" x2="0" y2="30" stroke="#b6b6b6" stroke-dasharray="3" stroke-linecap="butt" class="apexcharts-xcrosshairs" x="0" y="0" width="1" height="30" fill="#b1b9c4" filter="none" fill-opacity="0.9" stroke-width="1"></line><g id="SvgjsG1674" class="apexcharts-grid"><g id="SvgjsG1675" class="apexcharts-gridlines-horizontal" style="display: none;"><line id="SvgjsLine1679" x1="0" y1="5" x2="150" y2="5" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1680" x1="0" y1="10" x2="150" y2="10" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1681" x1="0" y1="15" x2="150" y2="15" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1682" x1="0" y1="20" x2="150" y2="20" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1683" x1="0" y1="25" x2="150" y2="25" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line></g><g id="SvgjsG1676" class="apexcharts-gridlines-vertical" style="display: none;"></g><line id="SvgjsLine1686" x1="0" y1="30" x2="150" y2="30" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line><line id="SvgjsLine1685" x1="0" y1="1" x2="0" y2="30" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line></g><g id="SvgjsG1677" class="apexcharts-grid-borders" style="display: none;"><line id="SvgjsLine1678" x1="0" y1="0" x2="150" y2="0" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1684" x1="0" y1="30" x2="150" y2="30" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line></g><g id="SvgjsG1669" class="apexcharts-line-series apexcharts-plot-series"><g id="SvgjsG1670" class="apexcharts-series" seriesName="series-1" data:longestSeries="true" rel="1" data:realIndex="0"><path id="SvgjsPath1673" d="M 0 27.5 L 15 12 L 30 24.5 L 45 5.5 L 60 18.5 L 75 27.5 L 90 18 L 105 14 L 120 7 L 135 25.5 L 150 3" fill="none" fill-opacity="1" stroke="var(--bs-primary)" stroke-opacity="1" stroke-linecap="butt" stroke-width="2" stroke-dasharray="0" class="apexcharts-line" index="0" clip-path="url(#gridRectMask169vazcf)" pathTo="M 0 27.5 L 15 12 L 30 24.5 L 45 5.5 L 60 18.5 L 75 27.5 L 90 18 L 105 14 L 120 7 L 135 25.5 L 150 3" pathFrom="M -1 35 L -1 35 L 15 35 L 30 35 L 45 35 L 60 35 L 75 35 L 90 35 L 105 35 L 120 35 L 135 35 L 150 35" fill-rule="evenodd"></path><g id="SvgjsG1671" class="apexcharts-series-markers-wrap" data:realIndex="0"><g class="apexcharts-series-markers"><circle id="SvgjsCircle1706" r="0" cx="0" cy="0" class="apexcharts-marker w476qdtwo no-pointer-events" stroke="#ffffff" fill="var(--bs-primary)" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" default-marker-size="0"></circle></g></g></g><g id="SvgjsG1672" class="apexcharts-datalabels" data:realIndex="0"></g></g><line id="SvgjsLine1687" x1="0" y1="0" x2="150" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1688" x1="0" y1="0" x2="150" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG1689" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG1690" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g></g><g id="SvgjsG1703" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG1704" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG1705" class="apexcharts-point-annotations"></g></g><g id="SvgjsG1663" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend" style="max-height: 15px;"></div><div class="apexcharts-tooltip apexcharts-theme-light"><div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: var(--bs-primary);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div><div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light"><div class="apexcharts-yaxistooltip-text"></div></div></div></div></td>
                    </tr>
                    <tr>
                    <td>
                        <a href="pages/examples/invoice.html" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR7429</a>
                    </td>
                    <td>Samsung Smart TV</td>
                    <td><span class="badge text-bg-info">Processing</span></td>
                    <td><div id="table-sparkline-4" style="min-height: 30px;"><div id="apexchartszmn79u73j" class="apexcharts-canvas apexchartszmn79u73j apexcharts-theme-light" style="width: 150px; height: 30px;"><svg id="SvgjsSvg1708" width="150" height="30" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><rect id="SvgjsRect1713" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe"></rect><g id="SvgjsG1750" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g><g id="SvgjsG1710" class="apexcharts-inner apexcharts-graphical" transform="translate(0, 0)"><defs id="SvgjsDefs1709"><clipPath id="gridRectMaskzmn79u73j"><rect id="SvgjsRect1715" width="156" height="32" x="-3" y="-1" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="forecastMaskzmn79u73j"></clipPath><clipPath id="nonForecastMaskzmn79u73j"></clipPath><clipPath id="gridRectMarkerMaskzmn79u73j"><rect id="SvgjsRect1716" width="154" height="34" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><line id="SvgjsLine1714" x1="0" y1="0" x2="0" y2="30" stroke="#b6b6b6" stroke-dasharray="3" stroke-linecap="butt" class="apexcharts-xcrosshairs" x="0" y="0" width="1" height="30" fill="#b1b9c4" filter="none" fill-opacity="0.9" stroke-width="1"></line><g id="SvgjsG1722" class="apexcharts-grid"><g id="SvgjsG1723" class="apexcharts-gridlines-horizontal" style="display: none;"><line id="SvgjsLine1727" x1="0" y1="5" x2="150" y2="5" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1728" x1="0" y1="10" x2="150" y2="10" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1729" x1="0" y1="15" x2="150" y2="15" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1730" x1="0" y1="20" x2="150" y2="20" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1731" x1="0" y1="25" x2="150" y2="25" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line></g><g id="SvgjsG1724" class="apexcharts-gridlines-vertical" style="display: none;"></g><line id="SvgjsLine1734" x1="0" y1="30" x2="150" y2="30" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line><line id="SvgjsLine1733" x1="0" y1="1" x2="0" y2="30" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line></g><g id="SvgjsG1725" class="apexcharts-grid-borders" style="display: none;"><line id="SvgjsLine1726" x1="0" y1="0" x2="150" y2="0" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1732" x1="0" y1="30" x2="150" y2="30" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line></g><g id="SvgjsG1717" class="apexcharts-line-series apexcharts-plot-series"><g id="SvgjsG1718" class="apexcharts-series" seriesName="series-1" data:longestSeries="true" rel="1" data:realIndex="0"><path id="SvgjsPath1721" d="M 0 25 L 15 12 L 30 24.5 L 45 5.5 L 60 18.5 L 75 22.5 L 90 28 L 105 24 L 120 17 L 135 25.5 L 150 8" fill="none" fill-opacity="1" stroke="var(--bs-primary)" stroke-opacity="1" stroke-linecap="butt" stroke-width="2" stroke-dasharray="0" class="apexcharts-line" index="0" clip-path="url(#gridRectMaskzmn79u73j)" pathTo="M 0 25 L 15 12 L 30 24.5 L 45 5.5 L 60 18.5 L 75 22.5 L 90 28 L 105 24 L 120 17 L 135 25.5 L 150 8" pathFrom="M -1 40 L -1 40 L 15 40 L 30 40 L 45 40 L 60 40 L 75 40 L 90 40 L 105 40 L 120 40 L 135 40 L 150 40" fill-rule="evenodd"></path><g id="SvgjsG1719" class="apexcharts-series-markers-wrap" data:realIndex="0"><g class="apexcharts-series-markers"><circle id="SvgjsCircle1754" r="0" cx="0" cy="0" class="apexcharts-marker w3ajvz74x no-pointer-events" stroke="#ffffff" fill="var(--bs-primary)" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" default-marker-size="0"></circle></g></g></g><g id="SvgjsG1720" class="apexcharts-datalabels" data:realIndex="0"></g></g><line id="SvgjsLine1735" x1="0" y1="0" x2="150" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1736" x1="0" y1="0" x2="150" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG1737" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG1738" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g></g><g id="SvgjsG1751" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG1752" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG1753" class="apexcharts-point-annotations"></g></g><g id="SvgjsG1711" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend" style="max-height: 15px;"></div><div class="apexcharts-tooltip apexcharts-theme-light"><div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: var(--bs-primary);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div><div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light"><div class="apexcharts-yaxistooltip-text"></div></div></div></div></td>
                    </tr>
                    <tr>
                    <td>
                        <a href="pages/examples/invoice.html" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR1848</a>
                    </td>
                    <td>Samsung Smart TV</td>
                    <td><span class="badge text-bg-warning">Pending</span></td>
                    <td><div id="table-sparkline-5" style="min-height: 30px;"><div id="apexchartse6jyggtt" class="apexcharts-canvas apexchartse6jyggtt apexcharts-theme-light" style="width: 150px; height: 30px;"><svg id="SvgjsSvg1756" width="150" height="30" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><rect id="SvgjsRect1761" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe"></rect><g id="SvgjsG1797" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g><g id="SvgjsG1758" class="apexcharts-inner apexcharts-graphical" transform="translate(0, 0)"><defs id="SvgjsDefs1757"><clipPath id="gridRectMaske6jyggtt"><rect id="SvgjsRect1763" width="156" height="32" x="-3" y="-1" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="forecastMaske6jyggtt"></clipPath><clipPath id="nonForecastMaske6jyggtt"></clipPath><clipPath id="gridRectMarkerMaske6jyggtt"><rect id="SvgjsRect1764" width="154" height="34" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><line id="SvgjsLine1762" x1="0" y1="0" x2="0" y2="30" stroke="#b6b6b6" stroke-dasharray="3" stroke-linecap="butt" class="apexcharts-xcrosshairs" x="0" y="0" width="1" height="30" fill="#b1b9c4" filter="none" fill-opacity="0.9" stroke-width="1"></line><g id="SvgjsG1770" class="apexcharts-grid"><g id="SvgjsG1771" class="apexcharts-gridlines-horizontal" style="display: none;"><line id="SvgjsLine1775" x1="0" y1="6" x2="150" y2="6" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1776" x1="0" y1="12" x2="150" y2="12" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1777" x1="0" y1="18" x2="150" y2="18" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1778" x1="0" y1="24" x2="150" y2="24" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line></g><g id="SvgjsG1772" class="apexcharts-gridlines-vertical" style="display: none;"></g><line id="SvgjsLine1781" x1="0" y1="30" x2="150" y2="30" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line><line id="SvgjsLine1780" x1="0" y1="1" x2="0" y2="30" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line></g><g id="SvgjsG1773" class="apexcharts-grid-borders" style="display: none;"><line id="SvgjsLine1774" x1="0" y1="0" x2="150" y2="0" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1779" x1="0" y1="30" x2="150" y2="30" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line></g><g id="SvgjsG1765" class="apexcharts-line-series apexcharts-plot-series"><g id="SvgjsG1766" class="apexcharts-series" seriesName="series-1" data:longestSeries="true" rel="1" data:realIndex="0"><path id="SvgjsPath1769" d="M 0 24 L 15 7.199999999999999 L 30 14.700000000000001 L 45 6.300000000000001 L 60 14.100000000000001 L 75 19.5 L 90 13.8 L 105 23.4 L 120 19.200000000000003 L 135 15.3 L 150 10.8" fill="none" fill-opacity="1" stroke="var(--bs-primary)" stroke-opacity="1" stroke-linecap="butt" stroke-width="2" stroke-dasharray="0" class="apexcharts-line" index="0" clip-path="url(#gridRectMaske6jyggtt)" pathTo="M 0 24 L 15 7.199999999999999 L 30 14.700000000000001 L 45 6.300000000000001 L 60 14.100000000000001 L 75 19.5 L 90 13.8 L 105 23.4 L 120 19.200000000000003 L 135 15.3 L 150 10.8" pathFrom="M -1 30 L -1 30 L 15 30 L 30 30 L 45 30 L 60 30 L 75 30 L 90 30 L 105 30 L 120 30 L 135 30 L 150 30" fill-rule="evenodd"></path><g id="SvgjsG1767" class="apexcharts-series-markers-wrap" data:realIndex="0"><g class="apexcharts-series-markers"><circle id="SvgjsCircle1801" r="0" cx="0" cy="0" class="apexcharts-marker wjjsuo9k3 no-pointer-events" stroke="#ffffff" fill="var(--bs-primary)" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" default-marker-size="0"></circle></g></g></g><g id="SvgjsG1768" class="apexcharts-datalabels" data:realIndex="0"></g></g><line id="SvgjsLine1782" x1="0" y1="0" x2="150" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1783" x1="0" y1="0" x2="150" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG1784" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG1785" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g></g><g id="SvgjsG1798" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG1799" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG1800" class="apexcharts-point-annotations"></g></g><g id="SvgjsG1759" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend" style="max-height: 15px;"></div><div class="apexcharts-tooltip apexcharts-theme-light"><div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: var(--bs-primary);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div><div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light"><div class="apexcharts-yaxistooltip-text"></div></div></div></div></td>
                    </tr>
                    <tr>
                    <td>
                        <a href="pages/examples/invoice.html" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR7429</a>
                    </td>
                    <td>iPhone 6 Plus</td>
                    <td><span class="badge text-bg-danger"> Delivered </span></td>
                    <td><div id="table-sparkline-6" style="min-height: 30px;"><div id="apexchartskspp1wi5g" class="apexcharts-canvas apexchartskspp1wi5g apexcharts-theme-light" style="width: 150px; height: 30px;"><svg id="SvgjsSvg1803" width="150" height="30" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><rect id="SvgjsRect1808" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe"></rect><g id="SvgjsG1843" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g><g id="SvgjsG1805" class="apexcharts-inner apexcharts-graphical" transform="translate(0, 0)"><defs id="SvgjsDefs1804"><clipPath id="gridRectMaskkspp1wi5g"><rect id="SvgjsRect1810" width="156" height="32" x="-3" y="-1" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="forecastMaskkspp1wi5g"></clipPath><clipPath id="nonForecastMaskkspp1wi5g"></clipPath><clipPath id="gridRectMarkerMaskkspp1wi5g"><rect id="SvgjsRect1811" width="154" height="34" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><line id="SvgjsLine1809" x1="0" y1="0" x2="0" y2="30" stroke="#b6b6b6" stroke-dasharray="3" stroke-linecap="butt" class="apexcharts-xcrosshairs" x="0" y="0" width="1" height="30" fill="#b1b9c4" filter="none" fill-opacity="0.9" stroke-width="1"></line><g id="SvgjsG1817" class="apexcharts-grid"><g id="SvgjsG1818" class="apexcharts-gridlines-horizontal" style="display: none;"><line id="SvgjsLine1822" x1="0" y1="7.5" x2="150" y2="7.5" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1823" x1="0" y1="15" x2="150" y2="15" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1824" x1="0" y1="22.5" x2="150" y2="22.5" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line></g><g id="SvgjsG1819" class="apexcharts-gridlines-vertical" style="display: none;"></g><line id="SvgjsLine1827" x1="0" y1="30" x2="150" y2="30" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line><line id="SvgjsLine1826" x1="0" y1="1" x2="0" y2="30" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line></g><g id="SvgjsG1820" class="apexcharts-grid-borders" style="display: none;"><line id="SvgjsLine1821" x1="0" y1="0" x2="150" y2="0" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1825" x1="0" y1="30" x2="150" y2="30" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line></g><g id="SvgjsG1812" class="apexcharts-line-series apexcharts-plot-series"><g id="SvgjsG1813" class="apexcharts-series" seriesName="series-1" data:longestSeries="true" rel="1" data:realIndex="0"><path id="SvgjsPath1816" d="M 0 28.125 L 15 16.5 L 30 25.875 L 45 4.125 L 60 21.375 L 75 24.375 L 90 24.75 L 105 14.25 L 120 20.25 L 135 22.875 L 150 13.5" fill="none" fill-opacity="1" stroke="var(--bs-primary)" stroke-opacity="1" stroke-linecap="butt" stroke-width="2" stroke-dasharray="0" class="apexcharts-line" index="0" clip-path="url(#gridRectMaskkspp1wi5g)" pathTo="M 0 28.125 L 15 16.5 L 30 25.875 L 45 4.125 L 60 21.375 L 75 24.375 L 90 24.75 L 105 14.25 L 120 20.25 L 135 22.875 L 150 13.5" pathFrom="M -1 30 L -1 30 L 15 30 L 30 30 L 45 30 L 60 30 L 75 30 L 90 30 L 105 30 L 120 30 L 135 30 L 150 30" fill-rule="evenodd"></path><g id="SvgjsG1814" class="apexcharts-series-markers-wrap" data:realIndex="0"><g class="apexcharts-series-markers"><circle id="SvgjsCircle1847" r="0" cx="0" cy="0" class="apexcharts-marker whjbt7mvb no-pointer-events" stroke="#ffffff" fill="var(--bs-primary)" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" default-marker-size="0"></circle></g></g></g><g id="SvgjsG1815" class="apexcharts-datalabels" data:realIndex="0"></g></g><line id="SvgjsLine1828" x1="0" y1="0" x2="150" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1829" x1="0" y1="0" x2="150" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG1830" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG1831" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g></g><g id="SvgjsG1844" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG1845" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG1846" class="apexcharts-point-annotations"></g></g><g id="SvgjsG1806" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend" style="max-height: 15px;"></div><div class="apexcharts-tooltip apexcharts-theme-light"><div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: var(--bs-primary);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div><div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light"><div class="apexcharts-yaxistooltip-text"></div></div></div></div></td>
                    </tr>
                    <tr>
                    <td>
                        <a href="pages/examples/invoice.html" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR9842</a>
                    </td>
                    <td>Call of Duty IV</td>
                    <td><span class="badge text-bg-success">Shipped</span></td>
                    <td><div id="table-sparkline-7" style="min-height: 30px;"><div id="apexchartsgzdqdrzc" class="apexcharts-canvas apexchartsgzdqdrzc apexcharts-theme-light" style="width: 150px; height: 30px;"><svg id="SvgjsSvg1849" width="150" height="30" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><rect id="SvgjsRect1854" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe"></rect><g id="SvgjsG1889" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g><g id="SvgjsG1851" class="apexcharts-inner apexcharts-graphical" transform="translate(0, 0)"><defs id="SvgjsDefs1850"><clipPath id="gridRectMaskgzdqdrzc"><rect id="SvgjsRect1856" width="156" height="32" x="-3" y="-1" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="forecastMaskgzdqdrzc"></clipPath><clipPath id="nonForecastMaskgzdqdrzc"></clipPath><clipPath id="gridRectMarkerMaskgzdqdrzc"><rect id="SvgjsRect1857" width="154" height="34" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><line id="SvgjsLine1855" x1="0" y1="0" x2="0" y2="30" stroke="#b6b6b6" stroke-dasharray="3" stroke-linecap="butt" class="apexcharts-xcrosshairs" x="0" y="0" width="1" height="30" fill="#b1b9c4" filter="none" fill-opacity="0.9" stroke-width="1"></line><g id="SvgjsG1863" class="apexcharts-grid"><g id="SvgjsG1864" class="apexcharts-gridlines-horizontal" style="display: none;"><line id="SvgjsLine1868" x1="0" y1="7.5" x2="150" y2="7.5" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1869" x1="0" y1="15" x2="150" y2="15" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1870" x1="0" y1="22.5" x2="150" y2="22.5" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line></g><g id="SvgjsG1865" class="apexcharts-gridlines-vertical" style="display: none;"></g><line id="SvgjsLine1873" x1="0" y1="30" x2="150" y2="30" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line><line id="SvgjsLine1872" x1="0" y1="1" x2="0" y2="30" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line></g><g id="SvgjsG1866" class="apexcharts-grid-borders" style="display: none;"><line id="SvgjsLine1867" x1="0" y1="0" x2="150" y2="0" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1871" x1="0" y1="30" x2="150" y2="30" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line></g><g id="SvgjsG1858" class="apexcharts-line-series apexcharts-plot-series"><g id="SvgjsG1859" class="apexcharts-series" seriesName="series-1" data:longestSeries="true" rel="1" data:realIndex="0"><path id="SvgjsPath1862" d="M 0 25.5 L 15 9 L 30 22.125 L 45 15.375 L 60 2.625 L 75 13.125 L 90 6 L 105 10.5 L 120 16.5 L 135 7.875 L 150 2.25" fill="none" fill-opacity="1" stroke="var(--bs-primary)" stroke-opacity="1" stroke-linecap="butt" stroke-width="2" stroke-dasharray="0" class="apexcharts-line" index="0" clip-path="url(#gridRectMaskgzdqdrzc)" pathTo="M 0 25.5 L 15 9 L 30 22.125 L 45 15.375 L 60 2.625 L 75 13.125 L 90 6 L 105 10.5 L 120 16.5 L 135 7.875 L 150 2.25" pathFrom="M -1 30 L -1 30 L 15 30 L 30 30 L 45 30 L 60 30 L 75 30 L 90 30 L 105 30 L 120 30 L 135 30 L 150 30" fill-rule="evenodd"></path><g id="SvgjsG1860" class="apexcharts-series-markers-wrap" data:realIndex="0"><g class="apexcharts-series-markers"><circle id="SvgjsCircle1893" r="0" cx="0" cy="0" class="apexcharts-marker w5t48vd1j no-pointer-events" stroke="#ffffff" fill="var(--bs-primary)" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" default-marker-size="0"></circle></g></g></g><g id="SvgjsG1861" class="apexcharts-datalabels" data:realIndex="0"></g></g><line id="SvgjsLine1874" x1="0" y1="0" x2="150" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1875" x1="0" y1="0" x2="150" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG1876" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG1877" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g></g><g id="SvgjsG1890" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG1891" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG1892" class="apexcharts-point-annotations"></g></g><g id="SvgjsG1852" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend" style="max-height: 15px;"></div><div class="apexcharts-tooltip apexcharts-theme-light"><div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: var(--bs-primary);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div><div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light"><div class="apexcharts-yaxistooltip-text"></div></div></div></div></td>
                    </tr>
                </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
            <a href="javascript:void(0)" class="btn btn-sm btn-primary float-start">
                Place New Order
            </a>
            <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-end">
                View All Orders
            </a>
            </div>
            <!-- /.card-footer -->
        </div>
        <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-4">
        <!-- Info Boxes Style 2 -->
        <div class="info-box mb-3 text-bg-warning">
            <span class="info-box-icon"> <i class="bi bi-tag-fill"></i> </span>
            <div class="info-box-content">
            <span class="info-box-text">Inventory</span>
            <span class="info-box-number">5,200</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        <div class="info-box mb-3 text-bg-success">
            <span class="info-box-icon"> <i class="bi bi-heart-fill"></i> </span>
            <div class="info-box-content">
            <span class="info-box-text">Mentions</span>
            <span class="info-box-number">92,050</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        <div class="info-box mb-3 text-bg-danger">
            <span class="info-box-icon"> <i class="bi bi-cloud-download"></i> </span>
            <div class="info-box-content">
            <span class="info-box-text">Downloads</span>
            <span class="info-box-number">114,381</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        <div class="info-box mb-3 text-bg-info">
            <span class="info-box-icon"> <i class="bi bi-chat-fill"></i> </span>
            <div class="info-box-content">
            <span class="info-box-text">Direct Messages</span>
            <span class="info-box-number">163,921</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        <div class="card mb-4">
            <div class="card-header">
            <h3 class="card-title">Browser Usage</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                </button>
                <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                <i class="bi bi-x-lg"></i>
                </button>
            </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
            <!--begin::Row-->
            <div class="row">
                <div class="col-12"><div id="pie-chart" style="min-height: 155.7px;"><div id="apexchartsa5v8ps6z" class="apexcharts-canvas apexchartsa5v8ps6z apexcharts-theme-light" style="width: 288px; height: 155.7px;"><svg id="SvgjsSvg1894" width="288" height="155.7" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG1896" class="apexcharts-inner apexcharts-graphical" transform="translate(22, 0)"><defs id="SvgjsDefs1895"><clipPath id="gridRectMaska5v8ps6z"><rect id="SvgjsRect1898" width="159" height="177" x="-3" y="-1" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="forecastMaska5v8ps6z"></clipPath><clipPath id="nonForecastMaska5v8ps6z"></clipPath><clipPath id="gridRectMarkerMaska5v8ps6z"><rect id="SvgjsRect1899" width="157" height="179" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><g id="SvgjsG1900" class="apexcharts-pie"><g id="SvgjsG1901" transform="translate(0, 0) scale(1)"><circle id="SvgjsCircle1902" r="44.612195121951224" cx="76.5" cy="76.5" fill="transparent"></circle><g id="SvgjsG1903" class="apexcharts-slices"><g id="SvgjsG1904" class="apexcharts-series apexcharts-pie-series" seriesName="Chrome" rel="1" data:realIndex="0"><path id="SvgjsPath1905" d="M 76.5 7.8658536585365795 A 68.63414634146342 68.63414634146342 0 0 1 144.63372613931523 84.77293215215802 L 120.7869219905549 81.87740589890271 A 44.612195121951224 44.612195121951224 0 0 0 76.5 31.887804878048776 L 76.5 7.8658536585365795 z" fill="rgba(13,110,253,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="2" stroke-dasharray="0" class="apexcharts-pie-area apexcharts-donut-slice-0" index="0" j="0" data:angle="96.92307692307692" data:startAngle="0" data:strokeWidth="2" data:value="700" data:pathOrig="M 76.5 7.8658536585365795 A 68.63414634146342 68.63414634146342 0 0 1 144.63372613931523 84.77293215215802 L 120.7869219905549 81.87740589890271 A 44.612195121951224 44.612195121951224 0 0 0 76.5 31.887804878048776 L 76.5 7.8658536585365795 z" stroke="#ffffff"></path></g><g id="SvgjsG1906" class="apexcharts-series apexcharts-pie-series" seriesName="Edge" rel="2" data:realIndex="1"><path id="SvgjsPath1907" d="M 144.63372613931523 84.77293215215802 A 68.63414634146342 68.63414634146342 0 0 1 92.92522632451681 143.1397627862661 L 87.17639711093592 119.81584581107296 A 44.612195121951224 44.612195121951224 0 0 0 120.7869219905549 81.87740589890271 L 144.63372613931523 84.77293215215802 z" fill="rgba(32,201,151,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="2" stroke-dasharray="0" class="apexcharts-pie-area apexcharts-donut-slice-1" index="0" j="1" data:angle="69.23076923076921" data:startAngle="96.92307692307692" data:strokeWidth="2" data:value="500" data:pathOrig="M 144.63372613931523 84.77293215215802 A 68.63414634146342 68.63414634146342 0 0 1 92.92522632451681 143.1397627862661 L 87.17639711093592 119.81584581107296 A 44.612195121951224 44.612195121951224 0 0 0 120.7869219905549 81.87740589890271 L 144.63372613931523 84.77293215215802 z" stroke="#ffffff"></path></g><g id="SvgjsG1908" class="apexcharts-series apexcharts-pie-series" seriesName="FireFox" rel="3" data:realIndex="2"><path id="SvgjsPath1909" d="M 92.92522632451681 143.1397627862661 A 68.63414634146342 68.63414634146342 0 0 1 30.987142431961068 127.87339622813366 L 46.91664258077469 109.89270754828688 A 44.612195121951224 44.612195121951224 0 0 0 87.17639711093592 119.81584581107296 L 92.92522632451681 143.1397627862661 z" fill="rgba(255,193,7,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="2" stroke-dasharray="0" class="apexcharts-pie-area apexcharts-donut-slice-2" index="0" j="2" data:angle="55.38461538461539" data:startAngle="166.15384615384613" data:strokeWidth="2" data:value="400" data:pathOrig="M 92.92522632451681 143.1397627862661 A 68.63414634146342 68.63414634146342 0 0 1 30.987142431961068 127.87339622813366 L 46.91664258077469 109.89270754828688 A 44.612195121951224 44.612195121951224 0 0 0 87.17639711093592 119.81584581107296 L 92.92522632451681 143.1397627862661 z" stroke="#ffffff"></path></g><g id="SvgjsG1910" class="apexcharts-series apexcharts-pie-series" seriesName="Safari" rel="4" data:realIndex="3"><path id="SvgjsPath1911" d="M 30.987142431961068 127.87339622813366 A 68.63414634146342 68.63414634146342 0 0 1 20.015204911591454 37.511361041427534 L 39.784883192534444 51.1573846769279 A 44.612195121951224 44.612195121951224 0 0 0 46.91664258077469 109.89270754828688 L 30.987142431961068 127.87339622813366 z" fill="rgba(214,51,132,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="2" stroke-dasharray="0" class="apexcharts-pie-area apexcharts-donut-slice-3" index="0" j="3" data:angle="83.07692307692307" data:startAngle="221.53846153846152" data:strokeWidth="2" data:value="600" data:pathOrig="M 30.987142431961068 127.87339622813366 A 68.63414634146342 68.63414634146342 0 0 1 20.015204911591454 37.511361041427534 L 39.784883192534444 51.1573846769279 A 44.612195121951224 44.612195121951224 0 0 0 46.91664258077469 109.89270754828688 L 30.987142431961068 127.87339622813366 z" stroke="#ffffff"></path></g><g id="SvgjsG1912" class="apexcharts-series apexcharts-pie-series" seriesName="Opera" rel="5" data:realIndex="4"><path id="SvgjsPath1913" d="M 20.015204911591454 37.511361041427534 A 68.63414634146342 68.63414634146342 0 0 1 60.07477367548317 9.860237213733896 L 65.82360288906406 33.18415418892704 A 44.612195121951224 44.612195121951224 0 0 0 39.784883192534444 51.1573846769279 L 20.015204911591454 37.511361041427534 z" fill="rgba(111,66,193,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="2" stroke-dasharray="0" class="apexcharts-pie-area apexcharts-donut-slice-4" index="0" j="4" data:angle="41.53846153846155" data:startAngle="304.6153846153846" data:strokeWidth="2" data:value="300" data:pathOrig="M 20.015204911591454 37.511361041427534 A 68.63414634146342 68.63414634146342 0 0 1 60.07477367548317 9.860237213733896 L 65.82360288906406 33.18415418892704 A 44.612195121951224 44.612195121951224 0 0 0 39.784883192534444 51.1573846769279 L 20.015204911591454 37.511361041427534 z" stroke="#ffffff"></path></g><g id="SvgjsG1914" class="apexcharts-series apexcharts-pie-series" seriesName="IE" rel="6" data:realIndex="5"><path id="SvgjsPath1915" d="M 60.07477367548317 9.860237213733896 A 68.63414634146342 68.63414634146342 0 0 1 76.48802108173126 7.865854703894399 L 76.49221370312532 31.887805557531358 A 44.612195121951224 44.612195121951224 0 0 0 65.82360288906406 33.18415418892704 L 60.07477367548317 9.860237213733896 z" fill="rgba(173,181,189,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="2" stroke-dasharray="0" class="apexcharts-pie-area apexcharts-donut-slice-5" index="0" j="5" data:angle="13.846153846153868" data:startAngle="346.15384615384613" data:strokeWidth="2" data:value="100" data:pathOrig="M 60.07477367548317 9.860237213733896 A 68.63414634146342 68.63414634146342 0 0 1 76.48802108173126 7.865854703894399 L 76.49221370312532 31.887805557531358 A 44.612195121951224 44.612195121951224 0 0 0 65.82360288906406 33.18415418892704 L 60.07477367548317 9.860237213733896 z" stroke="#ffffff"></path></g></g></g></g><line id="SvgjsLine1916" x1="0" y1="0" x2="153" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1917" x1="0" y1="0" x2="153" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line></g><g id="SvgjsG1897" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend apexcharts-align-center apx-legend-position-right" style="position: absolute; left: auto; top: 24px; right: 5px;"><div class="apexcharts-legend-series" rel="1" seriesname="Chrome" data:collapsed="false" style="margin: 2px 5px;"><span class="apexcharts-legend-marker" rel="1" data:collapsed="false" style="background: rgb(13, 110, 253) !important; color: rgb(13, 110, 253); height: 12px; width: 12px; left: 0px; top: 0px; border-width: 0px; border-color: rgb(255, 255, 255); border-radius: 12px;"></span><span class="apexcharts-legend-text" rel="1" i="0" data:default-text="Chrome" data:collapsed="false" style="color: rgb(55, 61, 63); font-size: 12px; font-weight: 400; font-family: Helvetica, Arial, sans-serif;">Chrome</span></div><div class="apexcharts-legend-series" rel="2" seriesname="Edge" data:collapsed="false" style="margin: 2px 5px;"><span class="apexcharts-legend-marker" rel="2" data:collapsed="false" style="background: rgb(32, 201, 151) !important; color: rgb(32, 201, 151); height: 12px; width: 12px; left: 0px; top: 0px; border-width: 0px; border-color: rgb(255, 255, 255); border-radius: 12px;"></span><span class="apexcharts-legend-text" rel="2" i="1" data:default-text="Edge" data:collapsed="false" style="color: rgb(55, 61, 63); font-size: 12px; font-weight: 400; font-family: Helvetica, Arial, sans-serif;">Edge</span></div><div class="apexcharts-legend-series" rel="3" seriesname="FireFox" data:collapsed="false" style="margin: 2px 5px;"><span class="apexcharts-legend-marker" rel="3" data:collapsed="false" style="background: rgb(255, 193, 7) !important; color: rgb(255, 193, 7); height: 12px; width: 12px; left: 0px; top: 0px; border-width: 0px; border-color: rgb(255, 255, 255); border-radius: 12px;"></span><span class="apexcharts-legend-text" rel="3" i="2" data:default-text="FireFox" data:collapsed="false" style="color: rgb(55, 61, 63); font-size: 12px; font-weight: 400; font-family: Helvetica, Arial, sans-serif;">FireFox</span></div><div class="apexcharts-legend-series" rel="4" seriesname="Safari" data:collapsed="false" style="margin: 2px 5px;"><span class="apexcharts-legend-marker" rel="4" data:collapsed="false" style="background: rgb(214, 51, 132) !important; color: rgb(214, 51, 132); height: 12px; width: 12px; left: 0px; top: 0px; border-width: 0px; border-color: rgb(255, 255, 255); border-radius: 12px;"></span><span class="apexcharts-legend-text" rel="4" i="3" data:default-text="Safari" data:collapsed="false" style="color: rgb(55, 61, 63); font-size: 12px; font-weight: 400; font-family: Helvetica, Arial, sans-serif;">Safari</span></div><div class="apexcharts-legend-series" rel="5" seriesname="Opera" data:collapsed="false" style="margin: 2px 5px;"><span class="apexcharts-legend-marker" rel="5" data:collapsed="false" style="background: rgb(111, 66, 193) !important; color: rgb(111, 66, 193); height: 12px; width: 12px; left: 0px; top: 0px; border-width: 0px; border-color: rgb(255, 255, 255); border-radius: 12px;"></span><span class="apexcharts-legend-text" rel="5" i="4" data:default-text="Opera" data:collapsed="false" style="color: rgb(55, 61, 63); font-size: 12px; font-weight: 400; font-family: Helvetica, Arial, sans-serif;">Opera</span></div><div class="apexcharts-legend-series" rel="6" seriesname="IE" data:collapsed="false" style="margin: 2px 5px;"><span class="apexcharts-legend-marker" rel="6" data:collapsed="false" style="background: rgb(173, 181, 189) !important; color: rgb(173, 181, 189); height: 12px; width: 12px; left: 0px; top: 0px; border-width: 0px; border-color: rgb(255, 255, 255); border-radius: 12px;"></span><span class="apexcharts-legend-text" rel="6" i="5" data:default-text="IE" data:collapsed="false" style="color: rgb(55, 61, 63); font-size: 12px; font-weight: 400; font-family: Helvetica, Arial, sans-serif;">IE</span></div></div><div class="apexcharts-tooltip apexcharts-theme-dark"><div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(13, 110, 253);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div><div class="apexcharts-tooltip-series-group" style="order: 2;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(32, 201, 151);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div><div class="apexcharts-tooltip-series-group" style="order: 3;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(255, 193, 7);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div><div class="apexcharts-tooltip-series-group" style="order: 4;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(214, 51, 132);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div><div class="apexcharts-tooltip-series-group" style="order: 5;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(111, 66, 193);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div><div class="apexcharts-tooltip-series-group" style="order: 6;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(173, 181, 189);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div></div></div></div>
                <!-- /.col -->
            </div>
            <!--end::Row-->
            </div>
            <!-- /.card-body -->
            <div class="card-footer p-0">
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                <a href="#" class="nav-link">
                    United States of America
                    <span class="float-end text-danger">
                    <i class="bi bi-arrow-down fs-7"></i>
                    12%
                    </span>
                </a>
                </li>
                <li class="nav-item">
                <a href="#" class="nav-link">
                    India
                    <span class="float-end text-success">
                    <i class="bi bi-arrow-up fs-7"></i> 4%
                    </span>
                </a>
                </li>
                <li class="nav-item">
                <a href="#" class="nav-link">
                    China
                    <span class="float-end text-info">
                    <i class="bi bi-arrow-left fs-7"></i> 0%
                    </span>
                </a>
                </li>
            </ul>
            </div>
            <!-- /.footer -->
        </div>
        <!-- /.card -->
        <!-- PRODUCT LIST -->
        <div class="card">
            <div class="card-header">
            <h3 class="card-title">Recently Added Products</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                </button>
                <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                <i class="bi bi-x-lg"></i>
                </button>
            </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
            <div class="px-2">
                <div class="d-flex border-top py-2 px-1">
                <div class="col-2">
                    <img src="admin/v1/assets/img/default-150x150.png" alt="Product Image" class="img-size-50">
                </div>
                <div class="col-10">
                    <a href="javascript:void(0)" class="fw-bold">
                    Samsung TV
                    <span class="badge text-bg-warning float-end"> $1800 </span>
                    </a>
                    <div class="text-truncate">Samsung 32" 1080p 60Hz LED Smart HDTV.</div>
                </div>
                </div>
                <!-- /.item -->
                <div class="d-flex border-top py-2 px-1">
                <div class="col-2">
                    <img src="admin/v1/assets/img/default-150x150.png" alt="Product Image" class="img-size-50">
                </div>
                <div class="col-10">
                    <a href="javascript:void(0)" class="fw-bold">
                    Bicycle
                    <span class="badge text-bg-info float-end"> $700 </span>
                    </a>
                    <div class="text-truncate">
                    26" Mongoose Dolomite Men's 7-speed, Navy Blue.
                    </div>
                </div>
                </div>
                <!-- /.item -->
                <div class="d-flex border-top py-2 px-1">
                <div class="col-2">
                    <img src="admin/v1/assets/img/default-150x150.png" alt="Product Image" class="img-size-50">
                </div>
                <div class="col-10">
                    <a href="javascript:void(0)" class="fw-bold">
                    Xbox One
                    <span class="badge text-bg-danger float-end"> $350 </span>
                    </a>
                    <div class="text-truncate">
                    Xbox One Console Bundle with Halo Master Chief Collection.
                    </div>
                </div>
                </div>
                <!-- /.item -->
                <div class="d-flex border-top py-2 px-1">
                <div class="col-2">
                    <img src="admin/v1/assets/img/default-150x150.png" alt="Product Image" class="img-size-50">
                </div>
                <div class="col-10">
                    <a href="javascript:void(0)" class="fw-bold">
                    PlayStation 4
                    <span class="badge text-bg-success float-end"> $399 </span>
                    </a>
                    <div class="text-truncate">PlayStation 4 500GB Console (PS4)</div>
                </div>
                </div>
                <!-- /.item -->
            </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer text-center">
            <a href="javascript:void(0)" class="uppercase"> View All Products </a>
            </div>
            <!-- /.card-footer -->
        </div>
        <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!--end::Row-->
    </div>
    <!--end::Container-->
</template>