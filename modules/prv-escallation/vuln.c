#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>

int main(int argc, char *argv[]) {
    if (argc < 2) {
        printf("Usage: %s <command> [args...]\n", argv[0]);
        return 1;
    }

    // Vulnerability: executes any command with root privileges
    setuid(0);
    setgid(0);

    execvp(argv[1], &argv[1]);

    perror("exec failed");
    return 1;
}

