var liquid = require('liquid-node'), assert = require("assert"), dir = require('node-dir'),fs = require('fs'), path = require('path');




describe('Liquid', function(){

    before(function(done){
        dir.readFiles('../../test/', {
            match: /.json$/
        }, function(err, content, filename, next) {
            var tests = JSON.parse(content);
            tests.forEach(function(item, index) {
                fs.readFile(path.dirname(filename)+'/template.liquid', 'utf8', function (err,template) {
                    if (err) {
                        return console.log(err);
                    }
                    fs.readFile(path.dirname(filename)+'/'+(index+1)+'.html', 'utf8', function (err,result) {
                        if (err) {
                            return console.log(err);
                        }
                        describe(path.dirname(filename)+'/'+(index+1)+'.html', function(){
                            it('Test', function(done){
                                liquid.Template.parse(template).render(item).done(function(n) {
                                    assert.equal(n, result);
                                    done()
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

