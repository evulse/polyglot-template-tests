var mu = require('mu2'), assert = require("assert"), dir = require('node-dir'),fs = require('fs'), path = require('path');




describe('Mustache', function(){

    before(function(done){
        dir.readFiles('../../test/Mustache/', {
            match: /.json$/
        }, function(err, content, filename, next) {
            var tests = JSON.parse(content);
            tests.forEach(function(item, index) {
                fs.readFile(path.dirname(filename)+'/template.mustache', 'utf8', function (err,template) {
                    if (err) {
                     //   return console.log(err);
                    }
                    fs.readFile(path.dirname(filename)+'/'+(index+1)+'.html', 'utf8', function (err,result) {
                        if (err) {
                         //   return console.log(err);
                        }
                        describe('Test', function(){
                            it(path.dirname(filename)+'/'+(index+1)+'.html', function(done){
               
                                var buffer = '';
                                
                                mu.compileAndRender(path.dirname(filename)+'/template.mustache', item)
                                    .on('data', function (c) { buffer += c.toString(); })
                                    .on('end', function () {         
                                        assert.equal(buffer, result);
                                        done();
                                    });
                            });
                        });
                    });
                });
                
            });
            next();
        }, function(err, files){
            if (err) throw err;
            done();
        });
        
    })
    
    
    it('Always Pass', function(done){
            assert.equal('a', 'a');
            done()
    });
})

