<meta charset='utf-8'/>
<title>New Widget</title>
<meta name='viewport' content='width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no'/>
@csrf
<style>body { margin: 0; min-height: 100vh; display: flex; justify-content: center; align-items: center; background-color: #acdcf3; }</style>

<script src='{{ asset('widgets/donation-2.js') }}'></script>
<link rel='stylesheet' href='{{ asset('widgets/donation-2.css') }}'/>
<script>window.DashDonate=window.DashDonate||{};window.DashDonate.key='{{ @$charity->api_site_id }}';</script>

<div id='dd_widget'></div>
