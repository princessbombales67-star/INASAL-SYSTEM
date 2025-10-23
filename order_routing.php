<!DOCTYPE html>
<html>
<head>
  <title>Order Tracking</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: linear-gradient(to right, #d1c4e9, #bbdefb);
      padding: 30px;
    }
    .container {
      background-color: white;
      border-radius: 15px;
      padding: 30px;
      width: 600px;
      margin: auto;
      box-shadow: 0px 4px 10px rgba(0,0,0,0.2);
    }
    h2 {
      color: #0077b6;
      text-align: center;
      margin-bottom: 20px;
    }
    label {
      font-weight: bold;
      display: block;
      margin-top: 15px;
    }
    input, select, textarea {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border-radius: 5px;
      border: 1px solid #ccc;
      font-size: 14px;
    }
    textarea {
      resize: none;
    }
    iframe {
      width: 100%;
      height: 300px;
      border: none;
      border-radius: 10px;
      margin-top: 15px;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>3. ORDER TRACKING</h2>

  <label>Counter No:</label>
  <input type="text" placeholder="Enter Counter No">

  <label>Customer Name:</label>
  <input type="text" placeholder="Enter Customer Name">

  <label>Current Status:</label>
  <select>
    <option>-- Select Status --</option>
    <option>Processing</option>
    <option>Shipped</option>
    <option>Delivered</option>
  </select>

  <label>Remarks:</label>
  <textarea placeholder="Optional remarks..."></textarea>

  <label>Location (Albay Astrodome):</label>
  <iframe 
    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3885.3551562942866!2d123.7323130736337!3d13.139983311167144!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a103dc7862f917%3A0x6807317c5dc2c4be!2sAlbay%20Astrodome!5e0!3m2!1sen!2sph!4v1760766254891!5m2!1sen!2sph" 
    allowfullscreen="" 
    loading="lazy" 
    referrerpolicy="no-referrer-when-downgrade">
  </iframe>
</div>

</body>
</html>
