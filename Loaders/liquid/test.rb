require "test/unit"
require "json"
require "liquid"

   assertTest = Struct.new :name, :expected, :template, :data

   polygotTests = []

   Dir["#{File.dirname(__FILE__)}/../../test/**/*.json"].each { |f|
     dataFile = File.open(f, "rb")
     data = JSON.parse(dataFile.read)
     data.to_enum.with_index(1) { |d, i|
       polygotTest = assertTest.new
       polygotTest.name = "test_"+File.dirname(f)+i.to_s
       templateFile = File.open(File.dirname(f)+'/template.liquid', "rb")
       polygotTest.template = templateFile.read
       templateFile.close
       expectFile = File.open(File.dirname(f)+'/'+i.to_s+'.html', "rb")
       polygotTest.expected = expectFile.read
       expectFile.close
       polygotTest.data = d
       polygotTests << polygotTest
     }
     dataFile.close

   }

   Class.new Test::Unit::TestCase do
     polygotTests.each do |t|
       define_method t.name do
         assert_equal Liquid::Template.parse(t.template).render(t.data), t.expected
       end
     end
   end
