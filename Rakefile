require 'rubygems'
require 'bundler'
Bundler.require

sprockets = Sprockets::Environment.new
sprockets.append_path "assets/source/javascripts"
sprockets.append_path "assets/source/stylesheets"

# CONFIG
sass = ['settings.css.sass']
coffee = ['settings.js.coffee']

# TASKS
namespace :build do
  desc "Clean output directories"
  task :clean do
    rmtree "assets/build"
    mkdir "assets/build"
    mkdir "assets/build/javascripts"
    mkdir "assets/build/stylesheets"
  end

  desc "Build for development"
  task :development => :clean do
    sass.each do |input|
      print "Building Sass... "
      output = canonical_filename(input)
      bundle = sprockets[input].to_s
      File.open("assets/build/stylesheets/#{output}", 'w') { |f| f.write bundle }
      puts "ok"
    end

    coffee.each do |input|
      print "Building CoffeeScript... "
      output = canonical_filename(input)
      bundle = sprockets[input].to_s
      File.open("assets/build/javascripts/#{output}", 'w') { |f| f.write bundle }
      puts "ok"
    end
  end

  desc "Build for production (minified files)"
  task :production => :clean do
    sass.each do |input|
      print "Building Sass... "
      output = canonical_filename(input)
      bundle = sprockets[input].to_s
      File.open("assets/build/stylesheets/#{output}", 'w') { |f| f.write bundle }
      puts "ok"
    end

    coffee.each do |input|
      print "Building CoffeeScript... "
      output = canonical_filename(input)
      bundle = sprockets[input].to_s
      File.open("assets/build/javascripts/#{output}", 'w') { |f| f.write Uglifier.compile(bundle) }
      puts "ok"
    end
  end
end

task :default => "build:development"

def canonical_filename(filename)
  filename.chomp(".coffee").chomp(".sass").chomp(".sass")
end
