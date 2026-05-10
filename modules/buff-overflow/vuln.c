/* Vulnerable buffer overflow program */
#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>

void print_flag() {
    setuid(0);
    setgid(0);

    FILE *fp = fopen("/root/flag.txt", "r");
    if (fp == NULL) {
        printf("Error opening flag file\n");
        return;
    }

    char flag[256];
    if (fgets(flag, sizeof(flag), fp) != NULL) {
        printf("FLAG: %s", flag);
    }
    fclose(fp);
}

int main() {
    int secret = 0xdeadbeef;
    char name[100] = {0};
    scanf("%s", name);
    if (secret == 0x1337) {
        print_flag();
    } else {
        puts("I guess you're not cool enough to see my secret");
    }
}

