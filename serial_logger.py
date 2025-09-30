import serial
import time

# Replace COM8 with your Arduino port
arduino = serial.Serial('COM8', 9600, timeout=1)
time.sleep(2)  # wait for Arduino to reset

log_file = "C:\\xampp\\htdocs\\dashboard\\iot\\arduino_log.txt"

while True:
    line = arduino.readline().decode(errors='ignore').strip()
    if line:
        timestamped_line = f"{time.strftime('%Y-%m-%d %H:%M:%S')} - {line}\n"
        with open(log_file, "a") as f:
            f.write(timestamped_line)
        print(timestamped_line, end="")