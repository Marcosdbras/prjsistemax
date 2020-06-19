import boto3
import sys, traceback
from datetime import datetime
from time import sleep

def start_ec2_instances():
    start_time = datetime.now()

    # starting ec2 client
    ec2_client = boto3.client('ec2')

    regions = ec2_client.describe_regions()

    for region in regions['Regions']:
        try:
            print("Region: " + str(region['RegionName']))
            ec2_client = boto3.client('ec2', region_name=region['RegionName'])
            instances = ec2_client.describe_instances()
            instanceIds = list()
            
            for reservation in instances['Reservations']:
                for instance in reservation['Instances']:
                    if instance['State']['Name'] == "stopped" and not instance['Tags'] is None : 
                        for tag in instance['Tags']:
                            try:
                                if tag['Key'] == 'ScheduledStartStop' and tag['Value'] == 'True'    :
                                    instanceIds.append(instance['InstanceId'])
                            except:
                                print "Not expected error: ", traceback.print_exc()
                      
            if len(instanceIds) > 0 : 
                print "Starting instances: " + str(instanceIds)
                ec2_client.start_instances(InstanceIds=instanceIds)                                                   
                                                            
        except:
            print "Not expected error:", traceback.print_exc()
                                                           
    end_time = datetime.now()
    took_time = end_time - start_time
    print "Total time of execution: " + str(took_time)    

def lambda_handler(event, context):
    print('Starting instances... ')
    start_ec2_instances()
	
	
	//https://medium.com/@cmacetko/aws-ligando-e-desligando-uma-instancia-ec2-em-hor%C3%A1rios-determinados-b43ad357ee52
	//https://www.linkedin.com/pulse/automa%C3%A7%C3%A3o-e-redu%C3%A7%C3%A3o-de-custos-na-aws-utilizando-tags-pierre-rezende
	//https://github.com/cmacetko/aws_start_stop
	//https://sa-east-1.console.aws.amazon.com/lambda/home?region=sa-east-1#/functions