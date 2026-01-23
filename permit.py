import os

file_count = 0
dir_count = 0

def recursive_permission(directory = "./"):
    global file_count, dir_count
    for file_path in os.listdir(directory):
        if file_path.startswith("."):
            continue
        file_path = directory + "/" + file_path
        if os.path.isdir(file_path):
            dir_count += 1
            os.chmod(file_path, 0o711)
            recursive_permission(file_path)
        else:
            file_count += 1
            os.chmod(file_path, 0o644)

recursive_permission()
print("Done!")
print("Finished with \033[1m" + str(file_count) + " files\033[0m and \033[1m" + str(dir_count) + " directories\033[0m.")