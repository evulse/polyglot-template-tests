require "test/unit"
require "json"
require "test/unit/runner/tap"
require "mustache"

   assertTest = Struct.new :name, :expected, :template, :data, :partials

   polygotTests = []

   Dir["#{File.dirname(__FILE__)}/../../test/Mustache/**/*.json"].each { |f|
     dataFile = File.open(f, "rb")
     data = JSON.parse(dataFile.read)
     data.to_enum.with_index(1) { |d, i|
       polygotTest = assertTest.new
       polygotTest.name = "test_"+File.dirname(f)+"/"+i.to_s+".html"
       templateFile = File.open(File.dirname(f)+'/template.mustache', "rb")
       polygotTest.template = templateFile.read
       templateFile.close
       expectFile = File.open(File.dirname(f)+'/'+i.to_s+'.html', "rb")
       polygotTest.expected = expectFile.read
       expectFile.close
       polygotTest.data = d
       polygotTest.partials = File.dirname(f)
       polygotTests << polygotTest
     }
     dataFile.close

   }

   Class.new Test::Unit::TestCase do
     polygotTests.each do |t|
       define_method t.name do
       Mustache.template_path = t.partials
         assert_equal Mustache.render(t.template, t.data), t.expected
       end
     end
   end
