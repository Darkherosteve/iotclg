import serial
import time
from collections import deque

# Replace COM8 with your Arduino port
arduino = serial.Serial('COM8', 9600, timeout=1)
time.sleep(2)  # wait for Arduino to reset

log_file = "C:\\xampp\\htdocs\\dashboard\\iot\\arduino_log.txt"
max_lines = 5  # store only last 5 lines

# Initialize a deque with max length to automatically keep only last 5 lines
last_lines = deque(maxlen=max_lines)

# Try to load existing lines from the file if it exists
try:
    with open(log_file, "r") as f:
        for line in f:
            last_lines.append(line.strip())
except FileNotFoundError:
    pass

while True:
    line = arduino.readline().decode(errors='ignore').strip()
    if line:
        timestamped_line = f"{time.strftime('%Y-%m-%d %H:%M:%S')} - {line}"
        last_lines.append(timestamped_line)

        # Overwrite file with only the last 5 lines
        with open(log_file, "w") as f:
            for l in last_lines:
                f.write(l + "\n")

        print(timestamped_line)
