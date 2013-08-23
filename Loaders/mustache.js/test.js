var Mustache = require('mustache'), assert = require("assert"), dir = require('node-dir'),fs = require('fs'), path = require('path');




describe('Mustache', function(){

    before(function(done){
        dir.readFiles('../../test/Mustache', {
            match: /.json$/
        }, function(err, content, filename, next) {
            var tests = JSON.parse(content);
            tests.forEach(function(item, index) {
                fs.readFile(path.dirname(filename)+'/template.mustache', 'utf8', function (err,template) {
   
                    fs.readFile(path.dirname(filename)+'/'+(index+1)+'.html', 'utf8', function (err,result) {
   
                        fs.readFile(path.dirname(filename)+'/partial.mustache', 'utf8', function (err,partial) {
             
                            describe('Test', function(){
                                it(path.dirname(filename)+'/'+(index+1)+'.html', function(done){
                                    var rendered = Mustache.render(template, item, {partial:partial});
                                        assert.equal(rendered, result);
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

