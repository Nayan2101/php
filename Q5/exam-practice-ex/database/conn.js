const mongoose = require('mongoose')

mongoose.connect("mongodb://localhost:27017/practice",{family: 4}).then(()=>{
    console.log("succes sfully connected database");
}).catch((err)=>{
    console.log("Failed to connect");
})

