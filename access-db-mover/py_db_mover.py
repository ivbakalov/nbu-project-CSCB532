import pyodbc
import mysql.connector
import collections

ACCESS_DB_PATH = r"path\\to\\accessdb.accdb"
DB_HOST = "db_host"
DB_USER = "db_user"
DB_PASSWORD= "db_password"
DB = "db_name"

def record_exists(access_cursor, table, unique_column, value):
    # Check if the record with the specified unique value exists in MS Access
    query = f"SELECT COUNT(*) FROM {table} WHERE {unique_column} = ?"
    access_cursor.execute(query, value)
    count = access_cursor.fetchone()[0]
    return count > 0

def move_data(mysql_connection, ms_access_connection):
   
    tables_for_moving = {"user": 'Email',"variant" : "VariantId", "survey": "SurveyId","group_text_mapping": "MappingId" }
    # MS Access Insert
    access_cursor = ms_access_connection.cursor()

    for table in tables_for_moving:
     print(table)
        # MySQL Query
     select_query = f"SELECT * FROM {table}"

    # Fetch records from MySQL
     mysql_cursor = mysql_connection.cursor()
     mysql_cursor.execute(select_query)
     
     column_names = [desc[0] for desc in mysql_cursor.description]
     columns_to_remove = ['referrer']
     new_column_names = column_names

     indexes_to_fetch = []
     for column_to_remove in columns_to_remove:
          if column_to_remove in column_names:
           new_column_names = [col for col in column_names if col != column_to_remove]
           indexes_to_fetch = [column_names.index(col) for col in new_column_names]


     for row in mysql_cursor.fetchall():
        print(row)   
        if record_exists(access_cursor, table, tables_for_moving[table], row[0]):
          continue

        new_record = row
       
        if len(indexes_to_fetch)>0:
         new_record = tuple(row[i] for i in indexes_to_fetch)
        
         

        columns = ", ".join(str(element) for element in new_column_names)
        
        data  = (("?"+", ")*(len(new_record)-1))+ "?"
              
            # Insert the record into MS Access
        insert_query = f"INSERT INTO {table} ({columns}) VALUES ({data})"
        try:
         access_cursor.execute(insert_query, new_record)
         ms_access_connection.commit()
        except Exception as e:
         print(f"An error occurred: {e}\n")
           
def main():
 
    # MySQL Connection
    mysql_connection = mysql.connector.connect(
        host=DB_HOST,
        user=DB_USER,
        password=DB_PASSWORD,
        database=DB,
    )

    # MS Access Connection
    ms_access_connection = pyodbc.connect(
        r"Driver={Microsoft Access Driver (*.mdb, *.accdb)};"
        f"DBQ={ACCESS_DB_PATH}"
    )

    move_data(mysql_connection, ms_access_connection)

    # Close Connections
    mysql_connection.close()
    ms_access_connection.close()

if __name__ == "__main__":
    main()