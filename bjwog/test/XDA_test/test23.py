import requests

url = "http://127.0.0.1/api/getGroupWithUserByGroupId"

payload=\
{
'group_id': '1'
}
files=\
[

]
headers = \
{
  'Cookie': 'XSRF-TOKEN=eyJpdiI6Ik1kUldSM3EwSHJpSWZteXJpb3lDQXc9PSIsInZhbHVlIjoibEFxKzdWXC9PUnFhSyt3Mlcyd3hGK2Z0UEdSNTRVMURsdFFkR0N3VWk0ZENSM1pXYlBxNEt5UjJYbDJxTTM2TVdQOFY4RzNqVVwvNUliZ1ErWkZPeEFIdz09IiwibWFjIjoiYTgwN2EwNjg1MTFkNTNkNDg3NjkyNzYwOTg1ZGZmMDUxMzBlOTVmODYyN2IzMzZjNTMxMDk0NmYwNGMyZWVlYSJ9; laravel_session=eyJpdiI6IlZQdUh2NXprS3FkOW9DNUlxbkM2Nmc9PSIsInZhbHVlIjoiajQrc2VQNEMzOFErenNleWdtZVZcLzNtNExHaXZXWVQ4eHhIR0M4Z0Z3dXJ4NW1MK1wvdDBsWkFieTAyXC94NUZaWVMwdHRMMGExVEFCbGUzZjlmQUFFUUE9PSIsIm1hYyI6IjhkZGY3MTNlNzVkNDVjZmI3YzM1YmZiNjIzNGRkMTViOWJhYzQxMDA4OGYxYzYyODVlZjg4NmNmY2JkZjM2ZDEifQ%3D%3D'
}

response = requests.request("POST", url, headers=headers, data=payload, files=files)

# 主函数
if __name__ == '__main__':

    # 读取指定网址中的数据
    response = requests.request("POST", url, headers=headers, data=payload, files=files)

    # 将数据转换为字典格式
    if response.content:
        # result = response.json()
        print(response.content)
