var swig = require('swig'), assert = require("assert"), dir = require('node-dir'),fs = require('fs'), path = require('path');


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
                        describe('Test', function(){
                            it(path.dirname(filename)+'/'+(index+1)+'.html', function(done){
                                var tpl = swig.compile(template);
                                var renderedHtml = tpl(item);
                                assert.equal(renderedHtml, result);
                                done()
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


    it('Test', function(done){
            assert.equal('a', 'a');
            done()
    });
})
