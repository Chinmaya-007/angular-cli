const express = require('express');
const bodyParser = require('body-parser');
const cors = require('cors');

const PORT=3000;
const app= express();
app.use(bodyParser.json());
app.use(cors());

app.get('/',function(req,res){
    res.send('Hello from server');
})
app.post('/login',function(req,res){
    console.log(req.body);
    res.status(401).send({"message":"Data Received"});
})
app.listen(PORT,function(){
    console.log("app is running on localhost:"+PORT);
})