#!/usr/bin/ruby

require "xmlrpc/client"

server = XMLRPC::Client.new("sarah.athnex.com", "/RPC2", 8080,nil,nil,'freeswitch','fs')
begin
	ShowStatus = server.call("freeswitch.api", "show", "status")
	puts "Server Status ==========="
	puts ShowStatus
	
	##### Registration block ###########################################
	ShowRegistration = server.call("freeswitch.api", "show", "registrations")
	RegistrationArray = ShowRegistration.split("\n")
	puts "Registration List ======="
	if RegistrationArray[1].eql? "0 total."
		puts "No open channels"
	else
		RegistrationArray.each do |line|
			regarray = line.split(",")
			if  regarray[0] =~ /\d+ total./ or regarray[0] == "reg_user" or regarray.empty?
				#puts "EMPTY: #{regarray}"
			else
				puts "User: #{regarray[0]} @ #{regarray[1]} (#{regarray[3]}) #{regarray[7]} #{regarray[5]}:#{regarray[6]}"
				#puts ""
				#puts "{#{callarray[0]}}"
			end
			#puts "#{regarray}"
		end
	end

    ##### Channel block ################################################
	ShowChannels = server.call("freeswitch.api", "show", "channels")
	ChannelArray = ShowChannels.split("\n")
	puts "Channel List ============"
	if ChannelArray[1].eql? "0 total."
		puts "No open channels"
	else
		ChannelArray.each do |line|
			callarray = line.split(",")
			if  callarray[0] =~ /\d+ total./ or callarray[0] == "uuid" or callarray.empty?
				#puts "EMPTY: #{callarray}"
			else
				puts " #{callarray[2]} UUID: #{callarray[0]} Direction: #{callarray[1]}"
				puts "	 #{callarray[6]} ( #{callarray[7]} ) Src IP:  #{callarray[8]} ---> Dest #{callarray[9]} [Codec #{callarray[17]}]"
				puts "  Application #{callarray[10]} ( #{callarray[11]} )"
				puts ""
			end
			#puts "#{callarray}"
		end
	end
	
rescue XMLRPC::FaultException => e
  puts "Error:"
  puts e.faultCode
  puts e.faultString
end
