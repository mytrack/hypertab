import sqlite3


"""
def a_db_create() :
    conn = sqlite3.connect("srt.db")
    print "Opened database successfully"

    cur = conn.cursor()
    conn.execute('''CREATE TABLE s_srt
        (id int primary key not null, 
         s_index int not null,
         s_start text not null,
         s_end   text not null,
         s_text  text not null);''')

    print "Table created successfully"
    conn.close()
"""

import pysrt
subs=pysrt.open('srt/brain.srt', encoding='utf-8')
#ksubs=pysrt.open('srt/X-Men_k.srt', encoding='utf-8')
def a_db_insert() :
    conn = sqlite3.connect("srt.db")
    conn.text_factory = str #utf-8 error
    print "Opened database successfully"

    for i in range(len(subs)):
		sub_i = subs[i]

		index=sub_i.index
		start=str(sub_i.start)
		end  =str(sub_i.end)
		text =str(sub_i.text)

		conn.execute("INSERT INTO s_srt(s_index,s_start,s_end,s_text) VALUES (?,?,?,?)",(index,start,end,text))           
		conn.commit()


    print "Records created successfully"
    #Close DB
    conn.close() 

# tablename A === a
def a_db_select() :
    conn = sqlite3.connect("srt.db")
    print "Opened database successfully"

    curs = conn.execute("SELECT id,s_index,s_start,s_end,s_text FROM s_srt")
    for col in curs :
        '''
        print "id = ", col[0]
        print "index = ", col[1]
        print "start = ", col[2]
        print "end = ", col[3]
        print "text = ", col[4], "\n"
        '''
        print '{:6}.  {:4}>[{:} ~ {:}] {:}'.format(col[0],col[1],col[2],col[3],col[4])

    print "Operation done successfully"
    #Close DB
    curs.close()
    conn.close()


if __name__ == "__main__" :
    a_db_insert()
    #a_db_select()



'''
#sudo pip install pysrt


# other stable version
#sudo pip install -U srt
# latest development version
sudo pip install -U git+https://github.com/cdown/srt.git@develop

sudo pip install tox
tox -e quick
'''

'''
import pysrt
subs=pysrt.open('srt/X-Men.srt', encoding='utf-8')
#ksubs=pysrt.open('srt/X-Men_k.srt', encoding='utf-8')

print "TOTAL SUB=",len(subs)

#for i in range(len(subs)):
for i in range(10):
	sub_i = subs[i]
	#sub_k = ksubs[i]

	print '{:5} ({:2} ~ {:2})'.format(sub_i.index,sub_i.start,sub_i.end) 
	#print '{:5}k({:2} ~ {:2})'.format(sub_k.index,sub_k.start,sub_k.end) 
	print '{:}'.format(sub_i.text) 
	#print '{:}'.format(sub_k.text) 

	#print '{:5} ({:2} ~ {:2})'.format(sub_i.index,sub_i.start.hours,sub_i.end.hours) 
	#print '{:5} ({:2} ~ {:2})'.format(sub_i.index,sub_i.start.minutes,sub_i.end.minutes) 
	#print '{:5} ({:2} ~ {:2})'.format(sub_i.index,sub_i.start.seconds,sub_i.end.seconds) 
	#print '{:}'.format(sub_i.text)
'''	

