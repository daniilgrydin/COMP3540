import os

file_count = 0
dir_count = 0

def recursive_permission(dir = "./"):
    global file_count, dir_count
    for file_path in os.listdir(dir):
        file_path = dir + "/" + file_path
        if os.path.isdir(file_path):
            dir_count += 1
            os.chmod(file_path, 0o711)
            recursive_permission(file_path)
        else:
            file_count += 1
            os.chmod(file_path, 0o644)

recursive_permission()
print("Done!")
print("Finished with", file_count, "files and", dir, "directories.")